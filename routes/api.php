<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('csrf_cookie', [CsrfCookieController::class, 'show']);

Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::post('users/forgot_password', [UserController::class, 'forgotPassword'])->name('password.request');
Route::get('users/forgot_password/{token}', [UserController::class, 'resetPassword'])->name('password.reset');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function () {
        return response()->json([
            [
                'name' => 'wallet_1',
                'value' => '127000.00'
            ],
            [
                'name' => 'wallet_2',
                'value' => '720.40'
            ]
        ], 200);
    });
});
