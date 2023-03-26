<?php

use Illuminate\Support\Facades\Route;
use App\Product\Controllers\API\ProductController;

Route::prefix('product')->group(function () {
    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('/', [ProductController::class,'index']);
        Route::post('/', [ProductController::class,'store']);
        Route::get('/{id}', [ProductController::class,'show']);
        Route::put('/{id}', [ProductController::class,'update']);
        Route::delete('/{id}', [ProductController::class,'destroy']);
    });
});
