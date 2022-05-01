<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\RatesController;
use Laravel\Sanctum\NewAccessToken;
use App\Http\Controllers\AuthController;

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

Route::post('/login', [AuthController::class,'login']);
Route::get('/', [ShippingController::class,'fetch']);
Route::resource('rates', RatesController::class)->middleware('auth:sanctum');
 

Route::get('/tokens/create', [AuthController::class,'login']);

