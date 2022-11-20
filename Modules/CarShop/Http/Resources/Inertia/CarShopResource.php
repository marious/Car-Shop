<?php
namespace Modules\CarShop\Http\Resources\Inertia;

use Illuminate\Http\Resources\Json\JsonResource;

class CarShopResource extends JsonResource
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
            'location' => $this->location,
            'commission' => $this->commission,
        ];
    }
}
