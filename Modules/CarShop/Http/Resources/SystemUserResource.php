<?php

namespace Modules\CarShop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CarShop\Entities\CarShop;

class SystemUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'userType' => $this->user_type,
            'carShop' => CarShopResource::make($this->whenLoaded('carShop')),
            'car_shop_id' => $this->car_shop_id,
            'is_active' => $this->is_active ? true : false,
            'user_type' => $this->user_type,
        ];
    }
}
