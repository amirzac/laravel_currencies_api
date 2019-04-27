<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AverageRate
 * @package App\Entity
 *
 * @property int $id
 * @property int $countRequests
 * @property float $value
 * @property string $code
 */
class AverageRate extends Model
{
    public $timestamps = false;

    protected $fillable = ['code', 'value', 'countRequests'];

    protected $table = 'average_rates';

    public function incrementRequestsAndUpdateValue(float $nawValue):void
    {
        $this->countRequests++;
        $this->value = round(($this->value + $nawValue), 4);
    }

    public function getAverageValue():?float
    {
        if($this->countRequests === 0) {
            return 0;
        }

        return round(($this->value / $this->countRequests), 4);
    }
}
