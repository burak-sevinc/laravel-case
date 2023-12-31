<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Repositories\CurrencyRepositoryInterface;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CurrencyController extends Controller
{
    private $currencyRepository;
    private $currencyService;

    public function __construct(CurrencyRepositoryInterface $currencyRepository, CurrencyService $currencyService)
    {
        $this->currencyRepository = $currencyRepository;
        $this->currencyService    = $currencyService;
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function __invoke(Request $request): JsonResponse
    {
        $currencies = $this->currencyRepository->all();

        return response()->json(['data' => $currencies], Response::HTTP_OK);
    }

    /**
     * Show currency function
     *
     * @param mixed $currencyCode
     * @return \Illuminate\Http\JsonResponse mixed
     */
    public function show($currencyCode): JsonResponse
    {
        $currency = $this->currencyService->findCurrency($currencyCode);

        if (!$currency) {
            return response()->json([
                'message' => 'Currency not found.',
            ], Response::HTTP_NOT_FOUND);
        }
        // Format the currency for the response
        $currency = $this->currencyService->formatCurrency($currency);

        return response()->json(['data' => $currency], Response::HTTP_OK);
    }

    /**
     * Create currency function
     *
     * @param \App\Http\Requests\StoreCurrencyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCurrencyRequest $request): JsonResponse
    {
        try {
            // Get camelCase data from request converted to snake_case
            $data = $request->data();

            // Create the currency
            $currency = $this->currencyRepository->create($data);

            // Return the response
            return response()->json([
                'message' => 'Currency created successfully.',
                'data' => $currency,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update currency function
     *
     * @param \App\Http\Requests\UpdateCurrencyRequest $request
     * @param mixed $currencyCode
     * @return \Illuminate\Http\JsonResponse mixed
     */
    public function update(UpdateCurrencyRequest $request, $currencyCode): JsonResponse
    {
        try {
            $currency = $this->currencyService->findCurrency($currencyCode);

            if (! $currency) {
                return response()->json(['message' => 'Currency not found.'], Response::HTTP_NOT_FOUND);
            };

            $data            = $request->data();
            $updatedCurrency = $this->currencyRepository->update($currency, $data);

            return response()->json([
                'message' => 'Currency updated successfully.',
                'data' => $updatedCurrency,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the currency.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Destroy
     *
     * @param $currencyCode
     * @throws \Exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($currencyCode): JsonResponse
    {
        try {
            $currency = $this->currencyService->findCurrency($currencyCode);

            if (! $currency) {
                return response()->json(['message' => 'Currency not found.'], Response::HTTP_NOT_FOUND);
            }

            $this->currencyRepository->delete($currencyCode);

            return response()->json(['message' => 'Currency deleted successfully.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the currency.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
