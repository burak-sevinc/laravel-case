<?php

namespace App\Repositories;

use App\Http\Resources\CurrencyResource;
use App\Models\Currency;

class EloquentCurrencyRepository implements CurrencyRepositoryInterface
{
    public function all()
    {
        $currencies = Currency::all();
        $data = $currencies->map(function($currency){
            return [
                'id' => $currency->id,
                'longName' => $currency->long_name,
                'currencyCode' => $currency->currency_code,
                'symbol' => $currency->symbol,
            ];
        });
        return $data;
    }

    public function create(array $data)
    {
        $currency = Currency::create([
            'long_name' => $data['long_name'],
            'currency_code' => $data['currency_code'],
            'symbol' => $data['symbol'],
            'created_by' => auth()->user()->id,
        ]);

        return CurrencyResource::make($currency);
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

        return CurrencyResource::make($currency);
    }

    public function delete($currencyCode)
    {
        $currency = Currency::where('currency_code', $currencyCode)->first();
        $currency->delete();
    }
}
