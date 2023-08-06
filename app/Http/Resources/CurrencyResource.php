<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * App\Https\Resources\CurrencyResource
 *
 * @property string $long_name
 * @property string $currency_code
 * @property string $symbol
 */

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'longName' => $this->long_name,
            'currencyCode' => $this->currency_code,
            'symbol' => $this->symbol,
        ];
    }
}
