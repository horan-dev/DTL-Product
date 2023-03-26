<?php

use Illuminate\Support\Facades\Route;
use App\Client\Controllers\API\LoginController;

Route::prefix('admin')->group(function () {

    Route::post('/login', [LoginController::class,'login']);

});
