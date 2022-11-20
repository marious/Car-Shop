<?php

namespace Modules\Car\Repositories;

use Modules\Car\Entities\CarBrand;
use Modules\Car\Entities\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Init\Repositories\Repository;

class CarModelRepository extends Repository
{
    private CarModel $model;

    public static function init(CarModel $model): CarModelRepository
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): CarModel
    {

        $model = new CarModel(self::prepareData($data));

        if (isset($data->car_brand)) {
            $model->carBrand()
                ->associate($data->car_brand->id);
        }


        $model->saveOrFail();
        return $model;
    }

    public function show(Request $request): CarModel
    {
//Fetch relationships
        $this->model->load([
            'carBrand',
        ]);
        return $this->model;
    }

    public function update(object $data): CarModel
    {

        $this->model->update(self::prepareData($data));

        if (isset($data->car_brand)) {
            $this->model->carBrand()
                ->associate($data->car_brand->id);
        }


        $this->model->saveOrFail();
        return $this->model;
    }

    public function destroy(): bool
    {
        return !!$this->model->delete();
    }

}
