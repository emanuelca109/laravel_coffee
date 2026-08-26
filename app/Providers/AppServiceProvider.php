<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(function (\Illuminate\Auth\Events\Login $event) {
            $user = $event->user;
            $dbCart = json_decode($user->carrito, true) ?? [];
            $sessionCart = session()->get('carrito', []);

            // Merge carts (session overrides db if same item)
            foreach ($sessionCart as $id => $data) {
                if (isset($dbCart[$id])) {
                    $dbCart[$id]['cantidad'] += $data['cantidad'];
                } else {
                    $dbCart[$id] = $data;
                }
            }

            session()->put('carrito', $dbCart);
            $user->carrito = json_encode($dbCart);
            $user->save();
        });
    }
}
