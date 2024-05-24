<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsContrib
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'contrib')) {
            return redirect('/')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}
