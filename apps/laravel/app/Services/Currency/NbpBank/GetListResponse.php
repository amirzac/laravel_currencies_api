<?php

namespace App\Services\Currency\NbpBank;

use App\Services\Currency\Response;

class GetListResponse extends Response implements \App\Services\Currency\GetListResponse
{
    public function getRates():iterable
    {
        $content = $this->getContent();

        $rateList = [
            'type' => 'success',
            'rates' => [],
        ];

        foreach ($content[0]->rates as $rate) {
            $rateList['rates'][$rate->code] = $rate->mid;
        }

        return $rateList;
    }
}