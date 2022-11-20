<?php

namespace Modules\Insurance\Http\Requests\CompanyPrice;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCompanyPriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->company_price);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'param_from' => ['required', 'numeric'],
            'param_to' => ['required', 'numeric'],
            'rate' => ['sometimes', 'numeric'],

            'company' => ['array', 'sometimes'],
            'price' => ['array', 'sometimes'],

        ];
    }

    public function messages()
    {
        return [
            'company.array' => 'Company Is Required',
            'price.array' => 'Price Is Required',
            'param_from.required' => 'From Is Required',
            'param_to.required' => 'To Is Required',
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
