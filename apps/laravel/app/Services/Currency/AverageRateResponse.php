<?php

namespace App\Services\Currency;

interface AverageRateResponse
{
    public function getValue():iterable;
}