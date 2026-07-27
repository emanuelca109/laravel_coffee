<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    // Campos que se pueden guardar masivamente
    protected $fillable = [
        'nombre',
    ];

    /**
     * Un rol tiene muchos usuarios.
     */
    public function users(): HasMany 
    {
        return $this->hasMany(User::class);
    }
}
