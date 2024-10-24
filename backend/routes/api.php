<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\SaleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('sellers', SellerController::class);
    Route::apiResource('sales', SaleController::class);
    Route::get('/sellers/{id}/sales', [SellerController::class, 'getSalesBySeller']);
    Route::get('/users/getByEmail/{email}', [UserController::class, 'getByEmail']);
});

Route::post('login', 'App\Http\Controllers\Auth\AuthController@login');