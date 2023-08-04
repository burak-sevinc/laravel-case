<?php
declare(strict_types=1);
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
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
}
