<?php

namespace Modules\CarShop\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Insurance\Entities\Company;
use Modules\Insurance\Http\Resources\Inertia\CompanyResource;

class PremimuTotalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'brand_name' => my_lang($this->car_brand_name),
            'car_model_name' => my_lang($this->car_model_name),
            'rate' => (float)$this->rate,
            'total_premium' => number_format($this->total_premim, 2),
            'premium' => number_format($this->premium),
            'commission' => (float)$this->commission,
            'sum_insured' => $this->sum_insured,
            'year' => $request->year,
            'price' => $request->price,
            'brandId' => $request['brands']['id'],
            'subBrandId' => $request['subBrand']['id'],
            'company' => CompanyResource::make(Company::findOrFail($this->company_id)),
        ];
    }
}
