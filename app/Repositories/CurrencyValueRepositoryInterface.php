<?php

namespace App\Repositories;

interface CurrencyValueRepositoryInterface
{
    public function getCurrency($currencyCode);
    public function getCurrencyValues($currencyCode);
}
