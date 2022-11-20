<?php

namespace Modules\Car\Repositories;

use Mockery\Exception;
use Modules\Car\Entities\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\CarShop\Entities\CarModel;
use Modules\Init\Repositories\Repository;

class CarBrandRepository extends Repository
{
    private CarBrand $model;

    public static function init(CarBrand $model): CarBrandRepository
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): CarBrand
    {

        $model = new CarBrand(self::prepareData($data));
// Save Relationships
        $model->saveOrFail();
        return $model;
    }

    public function show(Request $request): CarBrand
    {
//Fetch relationships
        return $this->model;
    }

    public function update(object $data): CarBrand
    {

        $this->model->update(self::prepareData($data));

        $this->model->saveOrFail();
        return $this->model;
    }

    public function destroy(): bool
    {
        if (CarModel::where('car_brand_id', $this->model->id)->count()) {
            throw new Exception('Cannot Delete This Car Brand');
        }
        return !!$this->model->delete();
    }

}
