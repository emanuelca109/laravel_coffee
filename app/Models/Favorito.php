<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ==========================================
// MODELO FAVORITO
// Representa un producto que a un usuario le gusta.
// Se conecta a la tabla 'favoritos' en la base de datos.
// ==========================================
class Favorito extends Model
{
    use HasFactory;

    // Le indicamos a Laravel el nombre exacto de la tabla
    protected $table = 'favoritos';

    // Los campos que podemos llenar directamente desde el controlador al crearlo masivamente
    protected $fillable = [
        'fecha',
        'user_id',
        'producto_id',
    ];

    // ==========================================
    // RELACIONES
    // ==========================================

    // Un registro de favorito pertenece a un Usuario específico
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un registro de favorito pertenece a un Producto específico
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
