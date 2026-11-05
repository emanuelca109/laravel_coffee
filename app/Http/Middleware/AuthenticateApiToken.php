<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiToken
{
    /**
     * Handle an incoming request for Flutter/mobile API.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tokenString = $request->bearerToken();

        if (!$tokenString) {
            $tokenString = $request->header('X-API-TOKEN') ?? $request->query('token');
        }

        if (!$tokenString) {
            return response()->json([
                'success' => false,
                'message' => 'No autenticado. Por favor incluye el encabezado Authorization: Bearer <token>',
            ], 401);
        }

        $token = PersonalAccessToken::findToken($tokenString);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token de autenticación no válido o revocado.',
            ], 401);
        }

        if ($token->expires_at && $token->expires_at->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'El token de autenticación ha expirado.',
            ], 401);
        }

        $user = $token->tokenable;

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado para este token.',
            ], 401);
        }

        $token->update(['last_used_at' => now()]);

        if (method_exists($user, 'withAccessToken')) {
            $user->withAccessToken($token);
        }

        Auth::setUser($user);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}

