<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->must_change_password
            && !$request->routeIs('password.force*') && !$request->routeIs('logout')) {
            return redirect()->route('password.force');
        }
        return $next($request);
    }
}