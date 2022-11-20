<?php

namespace Modules\CarShop\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
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
            'name' => $this->name,
            'brand' => \Modules\Car\Http\Resources\Inertia\CarBrandResource::make($this->carBrand)
        ];
    }
}
