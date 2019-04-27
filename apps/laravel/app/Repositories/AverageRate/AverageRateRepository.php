<?php

namespace App\Repositories\AverageRate;

use App\Entity\AverageRate;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AverageRateRepository.
 *
 * @package namespace App\Repositories\AverageRate;
 */
interface AverageRateRepository extends RepositoryInterface
{
    public function findOrCreateByCode($code):AverageRate;

    public function save(Model $model):void;
}
