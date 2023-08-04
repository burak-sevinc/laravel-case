<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Models\CurrencyValue;

class EloquentCurrencyValueRepository implements CurrencyValueRepositoryInterface
{
    public function getCurrency($currencyCode)
    {
        return Currency::where('currency_code', $currencyCode)->first();
    }
    public function getCurrencyValues($currencyCode)
    {
        $currency = Currency::where('currency_code', $currencyCode)->first();
        if (!$currency) {
            return null;
        }
        $values = CurrencyValue::select(['logged_at', 'currency_value'])->where('currency_id', $currency->id)->get();
        if ($values->isEmpty()) {
            return null;
        }
        return $values;
    }
}
