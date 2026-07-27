<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'monto',
        'factura',
        'metodo_pago',
        'fecha_pago',
        'estado_pago',
        'pedido_id',
        'venta_id',
    ];
}
