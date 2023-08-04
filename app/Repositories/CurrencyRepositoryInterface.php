<?php

namespace App\Repositories;

use App\Models\Currency;

interface CurrencyRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function find($currencyCode);
    public function update(Currency $currency, array $data);
    public function delete($currencyCode);
}
