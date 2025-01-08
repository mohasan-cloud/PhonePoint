<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Redirect to login page with a session message if not authenticated
            Session::flash('error', 'You must be logged in to access this page.');
            return redirect()->route('login');
        }

        // If authenticated, redirect to admin dashboard
        return redirect()->route('admin.dashboard');
    }
}
