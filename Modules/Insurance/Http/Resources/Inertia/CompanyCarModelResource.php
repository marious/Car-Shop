<?php
namespace Modules\Insurance\Http\Resources\Inertia;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CarShop\Transformers\CarModelResource;

class CompanyCarModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'car_model' => $this->car_model,
            'category' => $this->category,
            'company'   => CompanyResource::make($this->company),
            'model'     => CarModelResource::make($this->carModel),
        ];
    }
}
