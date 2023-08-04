<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CurrencyValueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::group(['prefix' => 'currencies'], function () {
    Route::get('/', [CurrencyController::class, 'index']);
    Route::post('/', [CurrencyController::class, 'store']);
    Route::get('/{currencyCode}', [CurrencyController::class, 'show']);
    Route::put('/{currencyCode}', [CurrencyController::class, 'update']);
    Route::delete('/{currencyCode}', [CurrencyController::class, 'destroy']);
});

Route::group(['prefix' => 'currency-values'], function () {
    Route::get('/{currencyCode}', [CurrencyValueController::class, 'index']);
    Route::post('/', [CurrencyValueController::class, 'store']);
    Route::put('/{id}', [CurrencyValueController::class, 'update']);
    Route::delete('/{id}', [CurrencyValueController::class, 'destroy']);
});
