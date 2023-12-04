<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserService
{
    /**
     * @param Request|null $request
     * @return Builder|Model|object|null
     */
    public function get(Request $request = null)
    {
        return $this->buildQuery($request)->first();
    }

    /**
     * @param Request|null $request
     * @return Builder
     */
    protected function buildQuery(Request $request = null): Builder
    {
        $query = User::query();

        if (!empty($request->name)) {
            $query->where('name', $request->string('name'));
        }

        if (!empty($request->email)) {
            $query->where('email', $request->string('email'));
        }

        return $query;
    }

    /**
     * @return bool
     */
    public function login(): bool
    {
        $credentials = request(['name', 'email', 'password']);
        return auth()->attempt($credentials);
    }

    /**
     * @param User $user
     * @return string
     */
    public function setAuthToken(User $user): string
    {
        $user->tokens()->where('name', 'auth-token')->delete();
        return $user->createToken('auth-token')->plainTextToken;
    }
}
