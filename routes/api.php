<?php

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

Route::get('/currencies', App\Http\Controllers\Currencies\CurrencyController::class);

Route::get('/currency-values/{currencyCode}', App\Http\Controllers\Currencies\CurrencyValueController::class);
