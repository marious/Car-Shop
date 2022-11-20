<?php

namespace Modules\Insurance\Repositories;

use Modules\Insurance\Entities\CompanyPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Init\Repositories\Repository;
use Modules\CarShop\Entities\CarShop;

class CompanyPriceRepository extends Repository
{
    private CompanyPrice $model;

    public static function init(CompanyPrice $model): CompanyPriceRepository
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): CompanyPrice
    {
        $model = new CompanyPrice(self::prepareData($data));


        if (isset($data->company)) {
            $model->company()
                ->associate($data->company->id);
        }
        if (isset($data->price)) {
            $model->price()
                ->associate($data->price->id);
        }


        $model->saveOrFail();
        return $model;
    }

    public function show(Request $request): CompanyPrice
    {
//Fetch relationships
        $this->model->load([
            'company',
            'price',
        ]);
        return $this->model;
    }

    public function update(object $data): CompanyPrice
    {
        $this->model->update(self::prepareData($data));

// Save Relationships


        if (isset($data->company)) {
            $this->model->company()
                ->associate($data->company->id);
        }


        if (isset($data->price)) {
            $this->model->price()
                ->associate($data->price->id);
        }


        $this->model->saveOrFail();
        return $this->model;
    }

    public function destroy(): bool
    {
        return !!$this->model->delete();
    }

}
