<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AuthService
{
    public function login(): bool
    {
        $credentials = request(['name', 'email', 'password']);
        return auth()->attempt($credentials);
    }

    public function setAuthToken(User $user): string
    {
        $user->tokens()->where('name', 'auth-token')->delete();
        return $user->createToken('auth-token')->plainTextToken;
    }
}
