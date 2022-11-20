<?php
namespace Modules\Insurance\Repositories;

use Modules\Insurance\Entities\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Init\Repositories\Repository;
use Modules\CarShop\Entities\CarShop;

class FeeRepository extends Repository
{
private Fee $model;
public static function init(Fee $model): FeeRepository
{
$instance = new self;
$instance->model = $model;
return $instance;
}

public static function store(object $data): Fee
{
$model = new Fee(self::prepareData($data));
// Save Relationships
    

$model->saveOrFail();
return $model;
}

public function show(Request $request): Fee {
//Fetch relationships
    return $this->model;
}
public function update(object $data): Fee
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
