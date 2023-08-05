<?php

namespace App\Repositories;

use App\Http\Resources\CurrencyValueResource;
use App\Models\Currency;
use App\Models\CurrencyValue;
use App\Services\CurrencyService;

class EloquentCurrencyValueRepository implements CurrencyValueRepositoryInterface
{
    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function getCurrencyValues($currencyCode)
    {
        $values = CurrencyValue::select(
            'currency_values.id',
            'currency_values.currency_value',
            'currency_values.logged_at'
        )
            ->join('currencies as c', 'c.id', '=', 'currency_values.currency_id')
            ->where('c.currency_code', $currencyCode)
            ->orderBy('logged_at', 'desc')
            ->get();

        if (!$values) {
            return null;
        }

        return CurrencyValueResource::collection($values);
    }

    public function getLastCurrencyValueByCode($currencyCode)
    {
        $value = CurrencyValue::select(
            'currency_values.id',
            'currency_values.currency_value',
            'currency_values.logged_at'
        )
            ->join('currencies as c', 'c.id', '=', 'currency_values.currency_id')
            ->where('c.currency_code', $currencyCode)
            ->orderBy('logged_at', 'desc')
            ->first();

        if (!$value) {
            return null;
        }


        return $value->currency_value;
    }

    public function create(array $data)
    {
        $currency = $this->currencyService->findCurrency($data['currency_code']);
        if (!$currency) {
            return null;
        }

        $currencyValue = CurrencyValue::create([
            'currency_id' => $currency->id,
            'currency_value' => $data['currency_value'],
            'logged_at' => now(),
        ]);

        return CurrencyValueResource::make($currencyValue);
    }

    public function find($id)
    {
        $currencyValue = CurrencyValue::find($id);
        return $currencyValue;
    }

    public function update(CurrencyValue $currencyValue, array $data)
    {
        $currencyValue->update([
            'currency_value' => $data['currency_value'],
        ]);

        return CurrencyValueResource::make($currencyValue);
    }

    public function delete($id)
    {
        $currencyValue = CurrencyValue::find($id);
        $currencyValue->delete();
    }
}
