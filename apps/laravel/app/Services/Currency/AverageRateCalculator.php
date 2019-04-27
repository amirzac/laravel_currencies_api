<?php

namespace App\Services\Currency;

use App\Entity\AverageRate;
use App\Repositories\AverageRate\AverageRateRepository;

class AverageRateCalculator
{
    private $averageRateRepository;

    public function __construct(AverageRateRepository $averageRateRepository)
    {
        $this->averageRateRepository = $averageRateRepository;
    }

    public function updateAverageValue(string $code, float $value):AverageRate
    {
        $averageRateModel = $this->averageRateRepository->findOrCreateByCode($code);
        $averageRateModel->incrementRequestsAndUpdateValue($value);
        $this->averageRateRepository->save($averageRateModel);

        return $averageRateModel;
    }
}