<?php
namespace Modules\Insurance\Http\Resources\Inertia;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyPriceResource extends JsonResource
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
            'param_from' => $this->param_from,
            'param_to' => $this->param_to,
            'rate' => $this->rate,
            'company'   => CompanyResource::make($this->company),
            'price'   => PriceResource::make($this->price),
        ];
    }
}
