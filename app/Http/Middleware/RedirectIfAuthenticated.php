<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  array<int, string>  $guards
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect($this->redirectPath($guard));
            }
        }

        return $next($request);
    }

    /**
     * Determine where an already-authenticated user for the given guard should be sent.
     */
    protected function redirectPath(?string $guard): string
    {
        if ($guard === 'staff') {
            $user = Auth::guard('staff')->user();

            return route($user->isAdmin() ? 'admin.dashboard' : 'teacher.dashboard');
        }

        return route('dashboard');
    }
}
