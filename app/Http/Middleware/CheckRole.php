<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::check() && Auth::user()->hasRole($role)) {
            return $next($request);
        }
        if (auth()->user()->hasRole('Super Admin')) {
            return redirect(route('admin.dashboard'));
        }elseif(auth()->user()->hasRole('user')){
            return redirect(route('admin.user.dashboard'));
        }else{
            return redirect()->route('login');  
        }
        
    }
}
