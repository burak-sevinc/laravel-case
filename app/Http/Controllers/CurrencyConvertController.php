<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyConvertRequest;
use App\Services\CurrencyService;
use App\Services\CurrencyValueService;
use Illuminate\Http\Response;

class CurrencyConvertController extends Controller
{
    protected $currencyService;
    protected $currencyValueService;

    public function __construct(CurrencyService $currencyService, CurrencyValueService $currencyValueService)
    {
        $this->currencyService = $currencyService;
        $this->currencyValueService = $currencyValueService;
    }
    public function __invoke(CurrencyConvertRequest $request)
    {
        $from = $request->validated()['from'];
        $to = $request->validated()['to'];
        $amount = $request->validated()['amount'];

        $fromValue = $this->currencyValueService->getLastCurrencyValueByCode($from);
        $toValue = $this->currencyValueService->getLastCurrencyValueByCode($to);

        if (!$fromValue || !$toValue) {
            return response()->json([
                'message' => 'Currency value not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $rate =  $fromValue->currency_value / $toValue->currency_value;

        return response()->json([
            'data' => [
                'amount' => $amount,
                'result' => round($rate * $amount, 4),
            ]
        ], 200);
    }
}
