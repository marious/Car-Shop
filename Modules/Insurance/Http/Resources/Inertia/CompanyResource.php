<?php
namespace Modules\Insurance\Http\Resources\Inertia;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'terms_conditions' => $this->terms_conditions,
            'bears_expenses' => $this->bear_expenses,
        ];
    }
}
