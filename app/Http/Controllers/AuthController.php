<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private AuthService $service)
    {
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
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

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!$this->service->login()) {
            return response()->json(
                ['message' => 'O email e/ou senha enviados estão incorretos.'],
                401
            );
        }

        try {
            $userService = new UserService();
            $user = $userService->get($request);
            $token = $this->service->setAuthToken($user);
        } catch (Exception $e) {
            throw new Exception('Erro ao autenticar usuário');
        }

        return response()->json(['token' => $token]);
    }
}
