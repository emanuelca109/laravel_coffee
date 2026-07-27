<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionEnvio extends Model
{
    use HasFactory;

    protected $table = 'informacion_envios';

    protected $fillable = [
        'fecha_envio',
        'fecha_entrega',
        'ciudad',
        'direccion',
        'transportadora',
        'estado',
        'pedido_id',
    ];

    protected $casts = [
        'fecha_envio' => 'date',
        'fecha_entrega' => 'date',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
}
