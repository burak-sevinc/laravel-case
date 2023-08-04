<?php

namespace App\Repositories;

use App\Models\Currency;

class EloquentCurrencyRepository implements CurrencyRepositoryInterface
{
    public function all()
    {
        return Currency::all();
    }

    public function create(array $data)
    {
        $currency = Currency::create([
            'long_name' => $data['long_name'],
            'currency_code' => $data['currency_code'],
            'symbol' => $data['symbol'],
            'created_by' => auth()->user()->id,
        ]);

        return $currency;
    }

    public function find($currencyCode)
    {
        $currency = Currency::where('currency_code', $currencyCode)->first();
        return $currency;
    }

    public function update($currency, array $data)
    {
        $currency->update([
            'long_name' => $data['long_name'],
            'currency_code' => $data['currency_code'],
            'symbol' => $data['symbol'],
        ]);

        return $currency;
    }

    public function delete($currencyCode)
    {
        $currency = Currency::where('currency_code', $currencyCode)->first();
        $currency->delete();
    }
}