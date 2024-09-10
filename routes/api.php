<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\BarcodeScannerController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/product/{kd_product}', [BarcodeScannerController::class, 'showByKodeProduct']);
    Route::post('/barcode/{kd_product}', [BarcodeScannerController::class, 'addToCart']);
});



// Route::post('/logout', [JWTAuthController::class, 'logout'])->middleware('auth:api');
// Route::get('/me', [JWTAuthController::class, 'me'])->middleware('auth:api');
Route::post('/login', [JWTAuthController::class, 'login']);


