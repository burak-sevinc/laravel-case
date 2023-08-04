<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CurrencyConvertTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testConvert(): void
    {
        $currencyConvertService = new \App\Services\CurrencyConvertService();
        $from = 2;
        $to = 4;
        $amount = 10;
        $expected = 5;
        $result = $currencyConvertService->convert($from, $to, $amount);
        $this->assertEquals($expected, $result);
    }
}
