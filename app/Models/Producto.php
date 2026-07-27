<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_compra',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'estado',
        'categoria_id',
        'proveedor_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }
    public function imagenPrincipal()
    {
    return $this->hasOne(Imagen::class)
                ->where('principal', true);
    }
    
    public function inventario()
    {
        return $this->hasOne(Inventario::class);
    }

    public function getStockReservadoAttribute()
    {
        return $this->inventario->stock_reservado ?? 0;
    }

    public function getStockDisponibleAttribute()
    {
        return $this->inventario->stock_disponible ?? $this->stock_actual;
    }

    public function getEstadoStockAttribute()
    {
        $minimo = $this->stock_minimo;
        $disponible = $this->stock_disponible;

        if ($disponible <= 0) {
        return 'Agotado';
        }

        if ($minimo > 0 && $disponible <= $minimo * 0.5) {
        return 'Crítico';
        }

        if ($minimo > 0 && $disponible <= $minimo) {
        return 'Bajo';
        }

        return 'Disponible';
    }

    /**
     * USUARIOS QUE TIENEN ESTE PRODUCTO COMO FAVORITO
     * Relación inversa de muchos a muchos con User.
     */
    public function favoritosPor()
    {
        return $this->belongsToMany(User::class, 'favoritos', 'producto_id', 'user_id')
                    ->withPivot('fecha', 'id')
                    ->withTimestamps();
    }
}