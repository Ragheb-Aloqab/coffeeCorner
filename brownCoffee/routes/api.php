<?php

use App\Http\Controllers\Api\v1\AuthApiController;
use App\Http\Controllers\Api\v1\CategoryApiController;
use App\Http\Controllers\Api\v1\OfferApiController;
use App\Http\Controllers\Api\v1\OrderApiController;
use App\Http\Controllers\Api\v1\ProductApiController;
use App\Http\Controllers\Api\v1\SettingApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Brown Coffee (v1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // ── Auth Routes ──
    Route::post('auth/register', [AuthApiController::class, 'register']);
    Route::post('auth/login', [AuthApiController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/profile', [AuthApiController::class, 'profile']);
        Route::post('auth/logout', [AuthApiController::class, 'logout']);
    });

    // ── Catalog Routes (Public) ──
    Route::get('categories', [CategoryApiController::class, 'index']);
    Route::get('categories/{id}', [CategoryApiController::class, 'show']);

    Route::get('products', [ProductApiController::class, 'index']);
    Route::get('products/{id}', [ProductApiController::class, 'show']);

    Route::get('offers', [OfferApiController::class, 'index']);

    // ── Settings Route ──
    Route::get('settings', [SettingApiController::class, 'index']);

    // ── Order Routes ──
    Route::post('orders', [OrderApiController::class, 'store']);
    Route::get('orders', [OrderApiController::class, 'index']);
    Route::get('orders/{orderNumber}', [OrderApiController::class, 'show']);
});
