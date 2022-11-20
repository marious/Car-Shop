<?php
namespace Modules\Insurance\Repositories;

use Modules\Insurance\Entities\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Init\Repositories\Repository;
use Modules\CarShop\Entities\CarShop;

class PriceRepository extends Repository
{
private Price $model;
public static function init(Price $model): PriceRepository
{
$instance = new self;
$instance->model = $model;
return $instance;
}

public static function store(object $data): Price
{
$model = new Price(self::prepareData($data));
// Save Relationships
    

$model->saveOrFail();
return $model;
}

public function show(Request $request): Price {
//Fetch relationships
    return $this->model;
}
public function update(object $data): Price
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
