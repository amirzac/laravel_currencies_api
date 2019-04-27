<?php

namespace App\Services\Currency\NbpBank;

use App\Entity\AverageRate;

class AverageRateResponse implements \App\Services\Currency\AverageRateResponse
{
    private $model;

    public function __construct(AverageRate $model)
    {
        $this->model = $model;
    }

    public function getValue(): iterable
    {
        return [
            'type' => 'success',
            'value' => $this->model->getAverageValue(),
        ];
    }
}