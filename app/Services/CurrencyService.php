<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\CurrencyResource;
use App\Repositories\EloquentCurrencyRepository;

class CurrencyService
{
    protected $currencyRepository;

    public function __construct(EloquentCurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function findCurrency($currencyCode)
    {
        return $this->currencyRepository->find($currencyCode);
    }

    public function formatCurrency($currency)
    {
        return CurrencyResource::make($currency);
    }
}
