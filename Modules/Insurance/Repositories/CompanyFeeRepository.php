<?php
namespace Modules\Insurance\Repositories;

use Modules\Insurance\Entities\CompanyFee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Init\Repositories\Repository;
use Modules\CarShop\Entities\CarShop;

class CompanyFeeRepository extends Repository
{
private CompanyFee $model;
public static function init(CompanyFee $model): CompanyFeeRepository
{
$instance = new self;
$instance->model = $model;
return $instance;
}

public static function store(object $data): CompanyFee
{
$model = new CompanyFee(self::prepareData($data));
// Save Relationships
            

                    if (isset($data->company)) {
            $model->company()
            ->associate($data->company->id);
            }
                    if (isset($data->fee)) {
            $model->fee()
            ->associate($data->fee->id);
            }
            

$model->saveOrFail();
return $model;
}

public function show(Request $request): CompanyFee {
//Fetch relationships
                    $this->model->load([
                    'company',
                    'fee',
                ]);
    return $this->model;
}
public function update(object $data): CompanyFee
{
$this->model->update(self::prepareData($data));

// Save Relationships
                        

            if (isset($data->company)) {
            $this->model->company()
            ->associate($data->company->id);
            }
                    

            if (isset($data->fee)) {
            $this->model->fee()
            ->associate($data->fee->id);
            }
            

$this->model->saveOrFail();
return $this->model;
}

    public function destroy(): bool
    {
    return !!$this->model->delete();
    }

}
