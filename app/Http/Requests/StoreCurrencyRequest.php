<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCurrencyRequest extends FormRequest
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
            'longName' => 'required|string',
            'currencyCode' => 'required|string|max:3|unique:currencies,currency_code',
            'symbol' => 'required|string|max:1',
        ];
    }

    public function data()
    {
        return [
            'long_name' => $this->input('longName'),
            'currency_code' => $this->input('currencyCode'),
            'symbol' => $this->input('symbol'),
        ];
    }
}
