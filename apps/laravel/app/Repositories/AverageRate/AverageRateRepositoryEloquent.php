<?php

namespace App\Repositories\AverageRate;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Entity\AverageRate;

/**
 * Class AverageRateRepositoryEloquent.
 *
 * @package namespace App\Repositories\AverageRate;
 */
class AverageRateRepositoryEloquent extends BaseRepository implements AverageRateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AverageRate::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {

    }

    public function findOrCreateByCode($code): AverageRate
    {
        $averageValue = $this->findByField('code', $code)->first();

        if(is_null($averageValue)) {
            $averageValue = new AverageRate([
                'code' => $code,
            ]);
        }

        return $averageValue;
    }

    public function save(Model $model):void
    {
        if(!$model->save()) {
            throw new \Exception("Can't save model");
        }
    }
}
