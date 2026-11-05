<?php

namespace App\Traits;

use App\Models\PersonalAccessToken;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

trait HasApiTokens
{
    protected $currentAccessToken;

    public function tokens(): MorphMany
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }

    public function createToken(string $name = 'mobile_token', array $abilities = ['*'])
    {
        $plainTextToken = Str::random(60);
        $hashedToken = hash('sha256', $plainTextToken);

        $token = $this->tokens()->create([
            'name' => $name,
            'token' => $hashedToken,
            'abilities' => $abilities,
            'expires_at' => now()->addMonths(6),
        ]);

        return new class($token, $plainTextToken) {
            public $accessToken;
            public $plainTextToken;

            public function __construct($accessToken, $plainTextToken)
            {
                $this->accessToken = $accessToken;
                $this->plainTextToken = $plainTextToken;
            }
        };
    }

    public function currentAccessToken()
    {
        return $this->currentAccessToken;
    }

    public function withAccessToken($accessToken)
    {
        $this->currentAccessToken = $accessToken;
        return $this;
    }
}

