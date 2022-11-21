<?php

use Illuminate\Http\Request;
use Modules\CarShop\Entities\CarShop;

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

Route::middleware('auth:api')->get('/carshop', function (Request $request) {
    return $request->user();
});

Route::get('car-shops', function (Request $request) {
    return \Modules\CarShop\Http\Resources\Inertia\CarShopResource::collection(
        CarShop::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->whereRaw('LOWER(JSON_EXTRACT(name, "$.en")) like ?', ['"%' . strtolower($search) . '%"'])
                    ->orWhereRaw('LOWER(JSON_EXTRACT(name, "$.ar")) like ?', ['"%' . strtolower($search) . '%"']);
            })
            ->paginate(request()->input('limit') ?: 15)
            ->withQueryString()
    );
})->name('api.car-shops.index');
