<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        $guard = auth('staff')->check() ? 'staff' : (auth()->check() ? 'web' : null);

        if ($guard && auth($guard)->user()->must_change_password
            && !$request->routeIs('password.force*') && !$request->routeIs('staff.password.force*')
            && !$request->routeIs('logout') && !$request->routeIs('staff.logout')) {
            return redirect()->route($guard === 'staff' ? 'staff.password.force' : 'password.force');
        }

        return $next($request);
    }
}
