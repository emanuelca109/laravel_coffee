<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    use HasFactory;

    protected $fillable = [
        'nombre_empresa',
        'nombre_proveedor',
        'telefono',
        'correo',
        'direccion',
        'estado',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}