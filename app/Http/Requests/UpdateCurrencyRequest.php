<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
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
        $currencyCode = $this->route('currencyCode');
        return [
            'long_name' => 'required|string',
            'currency_code' => 'required|string|max:3|unique:currencies,currency_code,' . $currencyCode . ',currency_code',
            'symbol' => 'required|string|max:1',
        ];
    }
}
