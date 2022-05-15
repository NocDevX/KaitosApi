<?php

use App\Http\Controllers\AuthController;
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

Route::post('index', function () {
    return 'index';
});

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

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
