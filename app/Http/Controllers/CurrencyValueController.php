<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CurrencyValueRepositoryInterface;

class CurrencyValueController extends Controller
{
    private $currencyValueRepository;
    public function __construct(CurrencyValueRepositoryInterface $currencyValueRepository)
    {
        $this->currencyValueRepository = $currencyValueRepository;
    }
    public function __invoke(Request $request, string $currencyCode)
    {
        $currency = $this->currencyValueRepository->getCurrency($currencyCode);
        if (!$currency) {
            return response()->json(['error' => 'Currency not found'], 404);
        }

        $values = $this->currencyValueRepository->getCurrencyValues($currency->currency_code);

        $currency_values = $values->map(static function ($value) {
            return [
                'logged_date' => $value['logged_at'],
                'value' => $value['currency_value'] * 100
            ];
        });

        return response()->json(['data' => [
            'currency' => $currency,
            'values' => $currency_values
        ]], 200);
    }
}
