<?php

namespace Modules\Insurance\Http\Requests\CompanyFee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Modules\Insurance\Entities\CompanyFee;

class StoreCompanyFeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', CompanyFee::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'fees_amount' => ['required', 'numeric'],
            'is_percent' => ['required', 'boolean'],

            'company' => ['array', 'required'],
            'fee' => ['array', 'required'],

        ];
    }

    public function messages()
    {
        return [
            'company' => __('Company Is Required'),
            'fee' => __('Fee Is Required'),
            'fees_amount' => __('Fees Amount Is Required'),
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
