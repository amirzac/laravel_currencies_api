<?php

namespace App\Services\Currency;

interface Client
{
    public function getList():GetListResponse;

    public function newestRate(string $code):NewestRateResponse;

    public function averageRate(string $code):AverageRateResponse;
}