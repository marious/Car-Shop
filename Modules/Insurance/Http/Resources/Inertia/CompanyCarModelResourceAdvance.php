<?php

namespace Modules\Insurance\Http\Resources\Inertia;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Car\Entities\CarBrand;
use Modules\Car\Entities\CarModel;
use Modules\CarShop\Transformers\CarBrandResource;
use Modules\CarShop\Transformers\CarModelResource;
use Modules\Insurance\Entities\Company;

class CompanyCarModelResourceAdvance extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company' => CompanyResource::make(Company::where('id', $this->company_id)->first()),
            'brand' => CarBrandResource::make(CarBrand::where('id', $this->brand_id)->first()),
            'models' => CarModelResource::collection(CarModel::whereIn('id', explode(',', $this->car_model))->get()),
            'category' => $this->category,
        ];
    }
}
