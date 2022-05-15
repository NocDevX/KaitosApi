<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\CreateRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(CreateRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = request(['name', 'email', 'password']);
        $isAuthenticated = auth()->attempt($credentials);

        if (!$isAuthenticated) {
            return response()->json([
                'message' => 'O email e/ou senha enviados estão incorretos.',
            ], 422);
        }

        $user = User::query();

        if (Arr::get($credentials, 'name')) {
            $user->where('name', $credentials['name']);
        }

        if (Arr::get($credentials, 'email')) {
            $user->where('email', $credentials['email']);
        }

        $user = $user->first();

        $user->tokens()->where('name', 'auth-token')->delete();
        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $authToken], 200);
    }
}
