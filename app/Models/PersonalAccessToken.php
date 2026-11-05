<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PersonalAccessToken extends Model
{
    protected $fillable = [
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
    ];

    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected $hidden = [
        'token',
    ];

    public function tokenable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function findToken(string $token): ?self
    {
        $hashedToken = hash('sha256', $token);
        return static::where('token', $hashedToken)
            ->orWhere('token', $token)
            ->first();
    }
}

