<?php

namespace App\Repositories;

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
        $currency = Currency::where('currency_code', $currencyCode)->first();
        if (!$currency) {
            return null;
        }
        $values = CurrencyValue::select(['id', 'logged_at', 'currency_value'])->where('currency_id', $currency->id)->get();
        if ($values->isEmpty()) {
            return null;
        }
        return $values;
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

        return $currencyValue;
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

        return $currencyValue;
    }

    public function delete($id)
    {
        $currencyValue = CurrencyValue::find($id);
        $currencyValue->delete();
    }
}
