<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowCurrencyValueRequest;
use App\Http\Requests\StoreCurrencyValueRequest;
use App\Http\Requests\UpdateCurrencyValueRequest;
use Illuminate\Http\Request;
use App\Repositories\CurrencyValueRepositoryInterface;
use App\Services\CurrencyService;
use App\Services\CurrencyValueService;
use Carbon\Carbon;
use Illuminate\Http\Response;

class CurrencyValueController extends Controller
{
    private $currencyValueRepository;
    private $currencyService;
    private $currencyValueService;
    public function __construct(
        CurrencyValueRepositoryInterface $currencyValueRepository,
        CurrencyService $currencyService,
        CurrencyValueService $currencyValueService
    ) {
        $this->currencyValueRepository = $currencyValueRepository;
        $this->currencyService = $currencyService;
        $this->currencyValueService = $currencyValueService;
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }
    public function __invoke(ShowCurrencyValueRequest $request)
    {
        $currencyCode = $request->validated()['currencyCode'];

        $currency = $this->currencyService->findCurrency($currencyCode);

        if (!$currency) {
            return response()->json(['error' => 'Currency not found'], 404);
        }

        $values = $this->currencyValueService->getCurrencyValues($currency->currency_code);

        if (!$values) {
            return response()->json(['error' => 'Currency values not found'], 404);
        }

        $currency_values = $values->map(static function ($value) {
            return [
                'id' => $value['id'],
                'loggedDate' => Carbon::parse($value['logged_at'])->format('Y-m-d'),
                'value' => $value['currency_value'] * 100
            ];
        });

        $formattedCurrency = $this->currencyService->formatCurrency($currency);

        return response()->json(['data' => [
            'currencyDetails' => $formattedCurrency,
            'values' => $currency_values
        ]], 200);
    }

    public function store(StoreCurrencyValueRequest $request)
    {
        try {
            $data = $request->data();

            // Create the currency value
            $currencyValue = $this->currencyValueRepository->create($data);
            if (!$currencyValue) {
                return response()->json([
                    'message' => 'Currency not found.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Return the response
            return response()->json([
                'message' => 'Currency value created successfully.',
                'data' => $currencyValue,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateCurrencyValueRequest $request, $id)
    {
        try {
            $currencyValue = $this->currencyValueRepository->find($id);

            if (!$currencyValue) {
                return response()->json([
                    'message' => 'Currency value not found.',
                ], Response::HTTP_NOT_FOUND);
            };

            $data = $request->data();
            $updatedCurrencyValue = $this->currencyValueRepository->update($currencyValue, $data);

            return response()->json([
                'message' => 'Currency value updated successfully.',
                'data' => $updatedCurrencyValue,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the currency value.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $currencyValue = $this->currencyValueRepository->find($id);

            if (!$currencyValue) {
                return response()->json([
                    'message' => 'Currency value not found.',
                ], Response::HTTP_NOT_FOUND);
            }

            $this->currencyValueRepository->delete($currencyValue->id);

            return response()->json([
                'message' => 'Currency value deleted successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the currency value.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
