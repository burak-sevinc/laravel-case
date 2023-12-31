<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * App\Https\Resources\CurrencyValueResource
 *
 * @property string $currency_id
 * @property string $currency_value
 * @property string $logged_at
 */
class CurrencyValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'currencyId' => $this->currency_id,
            'currencyValue' => $this->currency_value,
            'loggedDate' => Carbon::parse($this->logged_at)->format('Y-m-d'),
        ];
    }
}
