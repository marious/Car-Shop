<?php

namespace Modules\CarShop\Repositories;

use Modules\CarShop\Entities\CarShop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Init\Repositories\Repository;

class CarShopRepository extends Repository
{
    private CarShop $model;

    public static function init(CarShop $model): CarShopRepository
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): CarShop
    {
        $model = new CarShop(self::prepareData($data));
// Save Relationships


        $model->saveOrFail();
        return $model;
    }

    public function show(Request $request): CarShop
    {
//Fetch relationships
        return $this->model;
    }

    public function update(object $data): CarShop
    {

        $this->model->update(self::prepareData($data));

// Save Relationships


        $this->model->saveOrFail();
        return $this->model;
    }

    public function destroy(): bool
    {
        return !!$this->model->delete();
    }

}
