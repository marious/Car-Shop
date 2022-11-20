<?php

use Illuminate\Support\Facades\Route;
use Modules\Car\Http\Controllers\Admin\CarBrandController;
use Modules\Car\Http\Controllers\Admin\CarModelController;

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('car-brands', CarBrandController::class);
    Route::resource('car-models', CarModelController::class);
});
