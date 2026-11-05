<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registro de nuevo cliente desde Flutter.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'documento' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'role_id' => 2, // Rol cliente por defecto
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'documento' => $validated['documento'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'estado' => 'Activo',
        ]);

        $tokenResult = $user->createToken('flutter_mobile');

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado exitosamente',
            'token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'documento' => $user->documento,
                'telefono' => $user->telefono,
                'role_id' => $user->role_id,
            ],
        ], 201);
    }

    /**
     * Iniciar sesión desde Flutter.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'nullable|string',
        ]);

        $user = User::with('role')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Las credenciales proporcionadas son incorrectas.',
            ], 401);
        }

        if ($user->estado !== 'Activo') {
            return response()->json([
                'success' => false,
                'message' => 'Tu cuenta se encuentra inactiva. Contacta al administrador.',
            ], 403);
        }

        $deviceName = $request->device_name ?? 'flutter_mobile';
        $tokenResult = $user->createToken($deviceName);

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso',
            'token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'documento' => $user->documento,
                'telefono' => $user->telefono,
                'role_id' => $user->role_id,
                'role' => $user->role ? $user->role->nombre : null,
                'is_admin' => $user->role_id === 1 || strtolower($user->role->nombre ?? '') === 'admin',
            ],
        ]);
    }

    /**
     * Cerrar sesión (revocar token activo).
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && method_exists($user, 'currentAccessToken') && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente.',
        ]);
    }

    /**
     * Obtener el perfil del usuario autenticado.
     */
    public function me(Request $request)
    {
        $user = $request->user();
        $user->load(['role', 'direcciones']);

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'documento' => $user->documento,
                'telefono' => $user->telefono,
                'role_id' => $user->role_id,
                'role' => $user->role ? $user->role->nombre : null,
                'is_admin' => $user->role_id === 1 || strtolower($user->role->nombre ?? '') === 'admin',
                'direcciones_count' => $user->direcciones->count(),
                'favoritos_count' => $user->productosFavoritos()->count(),
            ],
        ]);
    }

    /**
     * Actualizar datos personales del usuario.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'documento' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Perfil actualizado exitosamente',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'documento' => $user->documento,
                'telefono' => $user->telefono,
            ],
        ]);
    }

    /**
     * Actualizar contraseña del usuario.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña actual no coincide.',
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada correctamente.',
        ]);
    }
}

