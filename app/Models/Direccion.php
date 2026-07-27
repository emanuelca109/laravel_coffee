<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones';

    protected $fillable = [
        'nombre_direccion',
        'nombre_completo',
        'telefono',
        'direccion',
        'departamento',
        'municipio',
        'codigo_postal',
        'referencias',
        'cliente_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id'); // Assuming user is acting as cliente
    }
}
