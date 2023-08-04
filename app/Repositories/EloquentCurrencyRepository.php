<?php

namespace App\Repositories;

use App\Models\Currency;

class EloquentCurrencyRepository implements CurrencyRepositoryInterface
{
    public function all()
    {
        return Currency::all();
    }
}
