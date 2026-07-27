<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_actual',
        'stock_reservado',
        'stock_disponible',
        'fecha_actualizacion',
        'producto_id',
    ];

    protected $casts = [
        'fecha_actualizacion' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function getEstadoAttribute()
    {
        $minimo = $this->producto->stock_minimo ?? 0;
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
}