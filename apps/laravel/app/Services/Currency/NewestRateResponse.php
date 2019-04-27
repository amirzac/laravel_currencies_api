<?php

namespace App\Services\Currency;


interface NewestRateResponse
{
    public function getCode():string ;

    public function getValue():string ;

    public function getInfo();
}