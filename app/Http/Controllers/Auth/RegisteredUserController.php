<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    
    public function store(Request $request): RedirectResponse 
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
        ]);
//AQUI ES PARA PONER QUE LOS NUEVOS USUARIOS SEAN  ROL2
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, //se agrega 
        ]);

        event(new Registered($user));

        if ($request->filled('intended_favorite_product')) {
            $productId = $request->input('intended_favorite_product');
            $user->productosFavoritos()->attach($productId, ['fecha' => now()]);
        }

        if ($request->filled('intended_buy_product')) {
            session()->put('pending_direct_buy', [
                'producto_id' => $request->input('intended_buy_product'),
                'cantidad' => $request->input('intended_buy_quantity', 1)
            ]);
        }

        //Auth::login($user); esto es para que cuando se registre lo mande directamente al dashboard

        return redirect()->to(url()->previous())
            ->with('success', 'Usuario registrado correctamente. Por favor, inicia sesión.')
            ->with('open_login', true);
    }
}
