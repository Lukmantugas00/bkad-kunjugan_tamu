<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {
        if (! auth()->check()) {
            Log::warning('ROLE CHECK: User belum login', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
            ]);

            return redirect()->route('login');
        }

        $user = auth()->user();

        $userRole = strtolower(
            trim((string) $user->role)
        );

        $allowedRoles = array_map(
            fn ($role) => strtolower(trim($role)),
            $roles
        );

        $accessGranted = in_array(
            $userRole,
            $allowedRoles,
            true
        );

        Log::info('ROLE CHECK', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_id' => $user->id,
            'user_role' => $userRole,
            'allowed_roles' => $allowedRoles,
            'access_granted' => $accessGranted,
        ]);

        if (! $accessGranted) {
            Log::warning('ROLE ACCESS DENIED', [
                'user_id' => $user->id,
                'user_role' => $userRole,
                'url' => $request->fullUrl(),
                'allowed_roles' => $allowedRoles,
            ]);

            abort(
                403,
                'Anda tidak memiliki akses ke halaman ini.'
            );
        }

        return $next($request);
    }
}
