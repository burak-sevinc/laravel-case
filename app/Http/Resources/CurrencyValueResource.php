<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'loggedAt' => $this->logged_at,
        ];
    }
}
