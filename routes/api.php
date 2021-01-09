<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('V1')->group(function () {
    Route::post('/register', [\App\Http\Controllers\ApiV1\UserController::class, 'store'])->name('api.user.store');
    Route::post('/user/token', [\App\Http\Controllers\ApiV1\UserController::class, 'authenticate'])->name('api.user.authenticate');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
