<?php

use Illuminate\Http\Request;
use Modules\Car\Entities\CarModel;

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

Route::middleware('auth:api')->get('/car', function (Request $request) {
    return $request->user();
});

Route::get('car-brands/{search?}', function (Request $request) {
    return \Modules\Car\Http\Resources\Inertia\CarBrandResource::collection(
        \Modules\Car\Entities\CarBrand::query()->when($request->input('search'), function ($query, $search) {
            $query->whereRaw('LOWER(JSON_EXTRACT(name, "$.en")) like ?', ['"%' . strtolower($search) . '%"'])
                ->orWhereRaw('LOWER(JSON_EXTRACT(name, "$.ar")) like ?', ['"%' . strtolower($search) . '%"']);
        })
        ->paginate($request->get('limit') ?: 15)
    );
})->name('api.car-brands.index');

Route::get('car-models', function (Request $request) {
    return \Modules\Car\Http\Resources\Inertia\CarBrandResource::collection(
        CarModel::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->whereRaw('LOWER(JSON_EXTRACT(name, "$.en")) like ?', ['"%' . strtolower($search) . '%"'])
                    ->orWhereRaw('LOWER(JSON_EXTRACT(name, "$.ar")) like ?', ['"%' . strtolower($search) . '%"']);
            })
            ->with('carBrand')
            ->paginate($request->get('limit') ?: 15)
    );
})->name('api.car-models.index');
