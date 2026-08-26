<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($request->filled('intended_favorite_product')) {
            $productId = $request->input('intended_favorite_product');
            // Add to favorites if not already there
            if (!$user->productosFavoritos()->where('producto_id', $productId)->exists()) {
                $user->productosFavoritos()->attach($productId, ['fecha' => now()]);
            }
        }

        if ($request->filled('intended_buy_product')) {
            session()->put('pending_direct_buy', [
                'producto_id' => $request->input('intended_buy_product'),
                'cantidad' => $request->input('intended_buy_quantity', 1)
            ]);
        }

        if ($user->role_id == 1) {
            return redirect()->route('dashboard');
        }

        return redirect()->intended(url()->previous());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        \Illuminate\Support\Facades\Log::info('Logout method executed');
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Has cerrado sesión exitosamente.');
    }
}
