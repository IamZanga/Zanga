<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaffRole
{
    /**
     * Handle an incoming request.
     *
     * Usage: ->middleware('role:admin') or ->middleware('role:admin,teacher')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = auth('staff')->user();

        abort_unless($user && in_array($user->role, $roles, true), 403);

        return $next($request);
    }
}
