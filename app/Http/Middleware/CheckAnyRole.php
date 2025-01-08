<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAnyRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (empty($roles) && $user->roles()->exists()) {
                // User has at least one role
                return $next($request);
            } elseif ($user->hasAnyRole($roles)) {
                // User has one of the specified roles
                return $next($request);
            }
        }
    
        abort(403, 'Unauthorized action.');
    }
    
}
