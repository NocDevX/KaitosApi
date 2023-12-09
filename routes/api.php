<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

// User
Route::get('csrf_cookie', [CsrfCookieController::class, 'show']);
Route::post('user/create', [UserController::class, 'create'])->name('user.create');
Route::prefix('user')->group(function () {
    Route::post('login', [UserController::class, 'login'])->name('user.login');
    Route::post('forgot_password', [UserController::class, 'forgotPassword']);
    Route::get('forgot_password/{token}', [UserController::class, 'resetPassword']);
});

// Wallets
Route::middleware('auth:sanctum')->group(function () {
    Route::get('wallets/{user}', [WalletController::class, 'get']);

    Route::prefix('wallet')->group(function () {
        Route::post('{user}', [WalletController::class, 'create']);
        Route::patch('{wallet}', [WalletController::class, 'update']);
        Route::delete('{wallet}', [WalletController::class, 'delete']);
    });
});
