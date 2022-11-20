<?php

use Modules\Insurance\Http\Controllers\Admin\CompanyCarModelController;
use Modules\Insurance\Http\Controllers\Admin\CompanyController;
use Modules\Insurance\Http\Controllers\Admin\CompanyFeeController;
use Modules\Insurance\Http\Controllers\Admin\CompanyPriceController;
use Modules\Insurance\Http\Controllers\Admin\CompoanyCarModelController;
use Modules\Insurance\Http\Controllers\Admin\FeeController;
use Modules\Insurance\Http\Controllers\Admin\PriceController;

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('fees', FeeController::class);
    Route::resource('prices', PriceController::class);
    Route::resource('company-fees', CompanyFeeController::class);
    Route::resource('company-prices', CompanyPriceController::class);
    Route::resource('company-car-models', CompanyCarModelController::class);
});

