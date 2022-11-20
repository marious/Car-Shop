<?php

namespace Modules\Insurance\Repositories;

use Modules\Init\Repositories\Repository;
use Modules\Insurance\Entities\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\CarShop\Entities\CarShop;

class CompanyRepository extends Repository
{
    private Company $model;

    public static function init(Company $model): CompanyRepository
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): Company
    {
        $model = new Company(self::prepareData($data));
// Save Relationships


        $model->saveOrFail();
        return $model;
    }

    public function show(Request $request): Company
    {
//Fetch relationships
        return $this->model;
    }

    public function update(object $data): Company
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
