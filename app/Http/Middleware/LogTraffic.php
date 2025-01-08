<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use App\Models\Traffic;

class LogTraffic
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Retrieve IP address
        $ip = $request->ip();

        // Check if the traffic record exists
        $traffic = Traffic::where('ip_address', $ip)->first();

        if (!$traffic) {
            // If no record exists, create one with location and details
            $location = $this->getLocationData($ip);
            $browser = $request->header('User-Agent');
            $referrer = $request->server('HTTP_REFERER') ?? 'Direct';

            $traffic = Traffic::create([
                'ip_address' => $ip,
                'location' => $location,
                'source' => $referrer,
                'browser' => $browser,
                'device' => $this->getDevice($browser),
                'visit_date' => now(),
                'views' => 1, // Initialize views
            ]);
        } else {
            // If a record exists, increment the views
            $traffic->increment('views');
        }

        // Store session data for time tracking if not already stored
        if (!session()->has('visit_start')) {
            session([
                'visit_start' => now(),
                'traffic_id' => $traffic->id,
            ]);
        }

        return $response;
    }

    /**
     * Determine device type based on User-Agent.
     */
    private function getDevice($userAgent)
    {
        if (str_contains($userAgent, 'Mobile')) {
            return 'Mobile';
        } elseif (str_contains($userAgent, 'Tablet')) {
            return 'Tablet';
        }
        return 'Desktop';
    }

    /**
     * Get location data from IP using ipstack API.
     */
    private function getLocationData($ip)
    {
        try {
            // Use ipstack API to get location data
            $apiKey = '25c4ca03e42bd358d5a9c59286475279';  // Replace with your ipstack API key
            $response = Http::get("http://api.ipstack.com/{$ip}?access_key={$apiKey}");
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['city'], $data['country_name'])) {
                    return "{$data['city']}, {$data['country_name']}";
                }
            }
        } catch (\Exception $e) {
            // Fallback for location if the API fails
            return 'Unknown';
        }
        return 'Unknown';
    }

    /**
     * Handle the termination phase to calculate the visit duration.
     */
    public function terminate($request, $response)
    {
        if (session()->has('visit_start') && session()->has('traffic_id')) {
            $visitStart = session('visit_start');
            $trafficId = session('traffic_id');

            // Calculate duration
            $duration = now()->diffInSeconds($visitStart);

            // Update traffic record with time spent
            $traffic = Traffic::find($trafficId);
            if ($traffic) {
                $traffic->update(['time_spent' => $duration]);
            }

            // Clear session data to avoid duplicate updates
            session()->forget(['visit_start', 'traffic_id']);
        }
    }
}
