<?php

namespace App\Repositories;

use App\Models\CurrencyValue;

interface CurrencyValueRepositoryInterface
{
    public function getCurrency($currencyCode);
    public function getCurrencyValues($currencyCode);
    public function create(array $data);
    public function find($id);
    public function update(CurrencyValue $currencyValue, array $data);
    public function delete($id);
}
