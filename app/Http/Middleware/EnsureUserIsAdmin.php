<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Ensure the authenticated user has administrative privileges.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $isAdmin = false;
        if ($user) {
            if ($user->role_id === 1) {
                $isAdmin = true;
            } elseif ($user->relationLoaded('role') && $user->role) {
                $roleName = strtolower($user->role->nombre ?? '');
                if (in_array($roleName, ['admin', 'administrador'])) {
                    $isAdmin = true;
                }
            } else {
                $user->load('role');
                $roleName = strtolower($user->role->nombre ?? '');
                if (in_array($roleName, ['admin', 'administrador'])) {
                    $isAdmin = true;
                }
            }
        }

        if (!$isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Acceso denegado. Se requieren permisos de administrador para esta acción.',
            ], 403);
        }

        return $next($request);
    }
}

