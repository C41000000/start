<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Catalog\Products\IndexController;
use App\Http\Controllers\Catalog\Products\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1/auth')->group(function () {
    Route::post('/login', LoginController::class);
});

Route::middleware('auth:api')->prefix('v1')->group(function () {

    Route::prefix('products')->group(function () {
       Route::post('/', StoreController::class)
           ->name('products.store');

       Route::get('/', IndexController::class)
           ->name('products.index');
    });

});
