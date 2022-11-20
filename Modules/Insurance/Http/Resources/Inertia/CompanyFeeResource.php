<?php
namespace Modules\Insurance\Http\Resources\Inertia;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyFeeResource extends JsonResource
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
            'fees_amount' => $this->fees_amount,
            'is_percent' => $this->is_percent,
            'company'   => CompanyResource::make($this->company),
            'fee' => FeeResource::make($this->fee),
        ];
    }
}
