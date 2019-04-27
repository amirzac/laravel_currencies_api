<?php

namespace App\Services\Currency;

interface GetListResponse
{
    public function getRates():iterable;
}