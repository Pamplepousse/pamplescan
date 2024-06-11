<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsContrib
{
    // Handle an incoming request and check if the user is an admin or contributor
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is not authenticated or does not have the 'admin' or 'contrib' role
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'contrib')) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}