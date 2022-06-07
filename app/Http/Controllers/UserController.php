<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return response()->json(['message' => __($status)]);
    }

    public function resetPassword(ResetPasswordRequest $request, $token)
    {
        $status = Password::reset($request->only('email', 'password', 'token'), function ($user, $password) {

            $user->forceFill(['password' => Hash::make($password)]);
            $user->setRememberToken(Str::random(30));

            $user->save();

            event(new PasswordReset($user));
        });

        return $status;
    }
}
