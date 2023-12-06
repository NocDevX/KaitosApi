<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @param LoginRequest $request
     * @param UserService $service
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginRequest $request, UserService $service): JsonResponse
    {
        if (!$service->login()) {
            return response()->json(
                ['message' => 'O email e/ou senha enviados estão incorretos.'],
                401
            );
        }

        try {
            $userService = new UserService();
            $user = $userService->get($request);

            $token = $service->setAuthToken($user);
        } catch (Exception $e) {
            throw new Exception('Erro ao autenticar usuário');
        }

        return response()->json(['token' => $token]);
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function create(CreateUserRequest $request): JsonResponse
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return response()->json(['message' => __($status)]);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return mixed
     */
    public function resetPassword(ResetPasswordRequest $request): mixed
    {
        return Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)]);
                $user->setRememberToken(Str::random(30));

                $user->save();

                event(new PasswordReset($user));
            }
        );
    }
}
