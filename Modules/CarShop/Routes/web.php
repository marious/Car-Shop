<?php

use Illuminate\Support\Facades\Route;
use Modules\CarShop\Http\Controllers\Admin\AccidentController;
use Modules\CarShop\Http\Controllers\Admin\ApprovedQuotationApiController;
use Modules\CarShop\Http\Controllers\Admin\CarShopController;
use Modules\CarShop\Http\Controllers\Admin\QuotationApiController;
use Modules\CarShop\Http\Controllers\Admin\QuotationController;
use Modules\CarShop\Http\Controllers\Admin\SystemUserController;
use Modules\CarShop\Pages\OrderPage;

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::resource('car-shops', CarShopController::class);
    Route::get('/', 'CarShopController@index');
    Route::get('order', [OrderPage::class, 'index'])->name('order.index');
    Route::get('order/sub_brand/{id}', [OrderPage::class, 'getSubBrand'])->name('order.get_sub_brand');
    Route::get('order/download', [OrderPage::class, 'orderPdf'])->name('order.download');
    Route::post('order/get_result', [OrderPage::class, 'getResult'])->name('order.get_result');
    Route::post('order/item_details', [OrderPage::class, 'getSingleDetail'])->name('order.item_details');
    Route::resource('system-users', SystemUserController::class);
    Route::get('/user/profile/{id}', [SystemUserController::class, 'getUserProfile'])->name('user.profile');
    Route::put('/user/profile/{id}', [SystemUserController::class, 'postUserProfile'])->name('user.post.profile');

    Route::get('/quotationsdata', [QuotationApiController::class, 'index'])->name('quotations.getData.index');
    Route::get('/quotations-approved', [ApprovedQuotationApiController::class, 'index'])->name('api.quotations.approved.index');
    Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
    Route::post('/quotations/store', [QuotationController::class, 'store'])->name('quotation.store');
    Route::get('/quotations/approved', [QuotationController::class, 'approved'])->name('quotations.approved');
    Route::get('/quotations/{id}', [QuotationController::class, 'show'])->name('quotations.show');
    Route::post('/quotations/{id}', [QuotationController::class, 'update'])->name('quotations.update');

    Route::get('accident/{quotationId}', [AccidentController::class, 'make'])
        ->name('accident.make');
    Route::get('accident/show/{quotationId}', [AccidentController::class, 'show'])->name('accident.show');
    Route::post('accident/{quotationId}', [AccidentController::class, 'store'])->name('accident.store');

    //
    Route::get('/quotation_companies', [\Modules\CarShop\Http\Controllers\Api\CompanyApiController::class, 'index'])
        ->name('quotation-companies');
});
