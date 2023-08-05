<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CurrencyValue;
use App\Repositories\EloquentCurrencyValueRepository;

class CurrencyValueService
{
    protected $currencyValueRepository;

    public function __construct(EloquentCurrencyValueRepository $currencyValueRepository)
    {
        $this->currencyValueRepository = $currencyValueRepository;
    }

    public function getCurrencyValues($currencyCode)
    {
        return $this->currencyValueRepository->getCurrencyValues($currencyCode);
    }

    public function getLastCurrencyValueByCode($currencyCode)
    {
        return $this->currencyValueRepository->getLastCurrencyValueByCode($currencyCode);
    }
}
