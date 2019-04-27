<?php

namespace App\Http\Controllers;

use App\Services\Currency\Client;
use Illuminate\Routing\Controller;

class CurrencyController extends Controller
{
    private $currencyClient;

    public function __construct(Client $currencyClient)
    {
        $this->currencyClient = $currencyClient;
    }

    public function list()
    {
        try {
            return $this->currencyClient->getList()->getRates();
        } catch (\Exception $e) {
            return $this->getExceptionData($e);
        }
    }

    public function newestRate($code)
    {
        try {
            return $this->currencyClient->newestRate($code)->getInfo();
        } catch (\Exception $e) {
            return $this->getExceptionData($e);
        }
    }

    public function averageRate($code)
    {
        try {
            return $this->currencyClient->averageRate($code)->getValue();
        } catch (\Exception $e) {
            return $this->getExceptionData($e);
        }
    }

    private function getExceptionData(\Exception $e):array
    {
        return [
            'code' => $e->getCode(),
            'type' => 'error',
            'title' => $e->getMessage(),
        ];
    }
}