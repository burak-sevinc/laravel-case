<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyConvertRequest;
use App\Services\CurrencyConvertService;
use App\Services\CurrencyService;
use App\Services\CurrencyValueService;
use Illuminate\Http\Response;

class CurrencyConvertController extends Controller
{
    protected $currencyService;
    protected $currencyValueService;
    protected $currencyConvertService;

    public function __construct(CurrencyService $currencyService, CurrencyValueService $currencyValueService, CurrencyConvertService $currencyConvertService)
    {
        $this->currencyService = $currencyService;
        $this->currencyValueService = $currencyValueService;
        $this->currencyConvertService = $currencyConvertService;
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
        
        $result = $this->currencyConvertService->convert($fromValue, $toValue, $amount);


        return response()->json([
            'data' => [
                'amount' => $amount,
                'result' => $result
            ]
        ], 200);
    }
}
