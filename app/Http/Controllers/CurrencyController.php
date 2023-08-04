<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use Illuminate\Http\Request;
use App\Repositories\CurrencyRepositoryInterface;
use Illuminate\Http\Response;

class CurrencyController extends Controller
{
    private $currencyRepository;
    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }
    public function __invoke(Request $request)
    {
        $currencies = $this->currencyRepository->all();
        return response()->json([
            'data' => $currencies,
        ], Response::HTTP_OK);
    }

    public function show($currencyCode)
    {
        $currency = $this->currencyRepository->find($currencyCode);

        if (!$currency) {
            return response()->json([
                'message' => 'Currency not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $currency,
        ], Response::HTTP_OK);
    }

    public function store(StoreCurrencyRequest $request)
    {
        try {
            // Add the user id to the request data
            $data = $request->validated();
            // $data['created_by'] = Auth::id();

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

    public function update(UpdateCurrencyRequest $request, $currencyCode)
    {
        try {
            $currency = $this->currencyRepository->find($currencyCode);

            if (!$currency) {
                return response()->json([
                    'message' => 'Currency not found.',
                ], Response::HTTP_NOT_FOUND);
            };

            $data = $request->validated();
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

    public function destroy($currencyCode)
    {
        try {
            $currency = $this->currencyRepository->find($currencyCode);

            if (!$currency) {
                return response()->json([
                    'message' => 'Currency not found.',
                ], Response::HTTP_NOT_FOUND);
            }

            $this->currencyRepository->delete($currencyCode);

            return response()->json([
                'message' => 'Currency deleted successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the currency.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}