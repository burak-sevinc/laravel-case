<?php

declare(strict_types=1);

namespace App\Services;

class CurrencyConvertService
{
    public function convert($from, $to, $amount)
    {
        $rate =  $from / $to;
        $result = round($rate * $amount, 4);
        return $result;
    }

}
