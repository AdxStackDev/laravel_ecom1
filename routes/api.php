<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api','throttle:ecommerce-api'])
    ->prefix('v1')
    ->group(function () {
        Route::apiResource('products', ProductApiController::class)
            ->scoped(['product' => 'slug']);
    });

// Public registration/login
Route::post('register', [UserController::class, 'register']);
Route::post('login',    [UserController::class, 'login'])->name('login');

// Protected (auth:sanctum required)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('users',         [UserController::class, 'index']);
    Route::get('users/{user}',  [UserController::class, 'show']);
    Route::put('users/{user}',  [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
});