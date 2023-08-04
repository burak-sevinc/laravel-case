<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCurrencyValueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'currencyCode' => 'required|string|max:3',
            'currencyValue' => 'required|numeric|regex:/^\d+(\.\d+)?$/',
        ];
    }

    public function data()
    {
        return [
            'currency_code' => $this->input('currencyCode'),
            'currency_value' => $this->input('currencyValue')
        ];
    }
}
