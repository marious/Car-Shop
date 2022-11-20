<?php

namespace Modules\Insurance\Http\Requests\CompanyCarModel;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCompanyCarModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->company_car_model);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'category' => ['required', 'integer'],
            'car_models' => ['array', 'required'],
            'car_brand' => ['array', 'required'],
            'company' => ['array', 'required'],

        ];
    }

    public function messages()
    {
        return [
            'car_models.array' => 'Car Model Is Required',
            'brand.array' => 'Car Brand Is Required',
            'company.array' => 'Company Is Required',
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function sanitizedArray(): array
    {
        $sanitized = $this->validated();


//Add your code for manipulation with request data here

        return $sanitized;
    }

    /**
     * Return modified (sanitized data) as a php object
     * @return object
     */
    public function sanitizedObject(): object
    {
        $sanitized = $this->sanitizedArray();
        return json_decode(collect($sanitized));
    }
}
