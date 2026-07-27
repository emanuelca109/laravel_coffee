<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['role_id', 'name', 'email', 'password', 'documento', 'telefono'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Un usuario pertenece a un rol.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * PRODUCTOS FAVORITOS
     * Relación de muchos a muchos con Producto a través de la tabla 'favoritos'.
     * Esto nos permite hacer auth()->user()->productosFavoritos para obtener la lista.
     */
    public function productosFavoritos()
    {
        return $this->belongsToMany(Producto::class, 'favoritos', 'user_id', 'producto_id')
                    ->withPivot('fecha', 'id') // Traemos la fecha en la que se guardó
                    ->withTimestamps();        // Para que se manejen los created_at/updated_at
    }

    /**
     * Un usuario tiene muchas direcciones.
     */
    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'cliente_id');
    }
}
