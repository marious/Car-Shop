<?php

namespace Modules\Insurance\Repositories;

use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Modules\Insurance\Entities\CompanyCarModel;
use Illuminate\Http\Request;
use Modules\Init\Repositories\Repository;

class CompanyCarModelRepository extends Repository
{
    private CompanyCarModel $model;

    public static function init(CompanyCarModel $model): CompanyCarModelRepository
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store($data)
    {
        try {
            $carModelsId = collect($data->car_models)->pluck('id');

            foreach ($carModelsId as $carModel) {
                // check if it exist before
                $isExistBefore = CompanyCarModel::where([
                    'car_model' => $carModel,
                    'company_id' => $data->company->id,
                ])->with('carModel')->first();

                if ($isExistBefore) {
                    throw new Exception('Cannot Add  (' . $isExistBefore->carModel->name . ') it exist before');
                }
            }

            foreach ($carModelsId as $carModel) {
                CompanyCarModel::create([
                    'car_model' => $carModel,
                    'company_id' => $data->company->id,
                    'category' => $data->category,
                ]);
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function show(Request $request): CompanyCarModel
    {
        $this->model->load([
            'carModelModel',
            'company',
        ]);
        return $this->model;
    }

    public function update(object $data)
    {
        try {
            $carModels = collect($data->car_models)->pluck('id');

            foreach ($carModels as $carModel) {
                $existInAnother = CompanyCarModel::where([
                    'company_id' => $this->model->company_id,
                    'car_model' => $carModel,
                ])
                    ->where('id', '!=', $this->model->id)
                    ->with('carModel')
                    ->first();
                if ($existInAnother) {
                    throw new Exception('Cannot Add  (' . $existInAnother->carModel->name . ') it exist before');
                }
            }

            $relatedCompanyCarModel = $this->getRelatedCarModelBrand($this->model);
            $relatedCompanyCarModelId = $relatedCompanyCarModel->pluck('id');
            CompanyCarModel::destroy($relatedCompanyCarModelId);

            foreach ($carModels as $carModel) {
                CompanyCarModel::create([
                    'car_model' => $carModel,
                    'company_id' => $data->company->id,
                    'category' => $data->category,
                ]);
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }


    }

    public function destroy(): bool
    {
        try {
            $relatedCompanyCarModel = $this->getRelatedCarModelBrand($this->model);
            $relatedCompanyCarModelId = $relatedCompanyCarModel->pluck('id');
            CompanyCarModel::destroy($relatedCompanyCarModelId);
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function getRelatedCarModelBrand(CompanyCarModel $companyCarModel)
    {
        return DB::table('company_car_model')
            ->select('company_car_model.*', 'car_brands.id AS brand_id')
            ->join('car_models', 'company_car_model.car_model', '=', 'car_models.id')
            ->join('car_brands', 'car_models.car_brand_id', '=', 'car_brands.id')
            ->where('car_brands.id', $companyCarModel->carModel->carBrand->id)
            ->where('company_car_model.company_id', $companyCarModel->company_id)
            ->where('company_car_model.category', $companyCarModel->category)
            ->get();
    }
}
