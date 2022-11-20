<?php

use Illuminate\Http\Request;
use Modules\Insurance\Entities\Company;
use Modules\Insurance\Entities\Fee;
use Modules\Insurance\Entities\Price;
use Modules\Insurance\Http\Resources\Inertia\CompanyResource;

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

Route::get('companies', function () {
    return \Modules\Insurance\Http\Resources\Inertia\CompanyResource::collection(Company::all());
})->name('api.companies.index');

Route::get('fees', function () {
    return \Modules\Insurance\Http\Resources\Inertia\FeeResource::collection(Fee::all());
})->name('api.fees.index');

Route::get('prices', function () {
    return \Modules\Insurance\Http\Resources\Inertia\FeeResource::collection(Price::all());
})->name('api.prices.index');

Route::get('company-fees', function () {
    return \Modules\Insurance\Http\Resources\Inertia\FeeResource::collection(\Modules\Insurance\Entities\CompanyFee::all
    ());
})->name('api.company-fees.index');

Route::get('company-price', function () {
    return CompanyResource::collection(\Modules\Insurance\Entities\CompanyPrice::all
    ());
})->name('api.company-price.index');
