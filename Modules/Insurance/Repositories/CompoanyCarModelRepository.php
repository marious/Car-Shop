<?php
namespace Modules\Insurance\Repositories;

use Modules\Insurance\Entities\CompoanyCarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Init\Repositories\Repository;
use Modules\CarShop\Entities\CarShop;

class CompoanyCarModelRepository extends Repository
{
private CompoanyCarModel $model;
public static function init(CompoanyCarModel $model): CompoanyCarModelRepository
{
$instance = new self;
$instance->model = $model;
return $instance;
}

public static function store(object $data): CompoanyCarModel
{
$model = new CompoanyCarModel(self::prepareData($data));
// Save Relationships
    

$model->saveOrFail();
return $model;
}

public function show(Request $request): CompoanyCarModel {
//Fetch relationships
    return $this->model;
}
public function update(object $data): CompoanyCarModel
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
