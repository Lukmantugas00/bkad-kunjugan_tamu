<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MustChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is not authenticated, let the auth middleware handle it.
        if (! $request->user() || ! $request->user()->authenticated) {
            return $next($request);
        }

        $user = $request->user();

        // If user must change password, redirect to password change page unless they are already on allowed routes.
        if ($user->must_change_password) {
            $allowedRoutes = [
                'password.change', // we will define this route
                'password.update', // for form submission
                'logout',
            ];

            $currentRoute = $request->route()->getName() ?? '';

            if (! in_array($currentRoute, $allowedRoutes, true)) {
                return Redirect()->route('password.change')
                    ->with('warning', 'Anda harus mengganti password sementara.');
            }
        }

        return $next($request);
    }
}