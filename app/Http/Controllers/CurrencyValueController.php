<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrencyValueRequest;
use App\Http\Requests\UpdateCurrencyValueRequest;
use Illuminate\Http\Request;
use App\Repositories\CurrencyValueRepositoryInterface;
use App\Services\CurrencyService;
use Illuminate\Http\Response;

class CurrencyValueController extends Controller
{
    private $currencyValueRepository;
    private $currencyService;
    public function __construct(CurrencyValueRepositoryInterface $currencyValueRepository, CurrencyService $currencyService)
    {
        $this->currencyValueRepository = $currencyValueRepository;
        $this->currencyService = $currencyService;
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }
    public function __invoke(string $currencyCode)
    {
        $currency = $this->currencyService->findCurrency($currencyCode);
        if (!$currency) {
            return response()->json(['error' => 'Currency not found'], 404);
        }

        $values = $this->currencyValueRepository->getCurrencyValues($currency->currency_code);

        $currency_values = $values->map(static function ($value) {
            return [
                'id' => $value['id'],
                'logged_date' => $value['logged_at'],
                'value' => $value['currency_value'] * 100
            ];
        });

        return response()->json(['data' => [
            'currency' => $currency,
            'values' => $currency_values
        ]], 200);
    }

    public function store(StoreCurrencyValueRequest $request)
    {
        try {
            $data = $request->validated();

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

            $data = $request->validated();
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
