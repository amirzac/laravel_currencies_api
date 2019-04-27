<?php

namespace App\Services\Currency\NbpBank;

use App\Services\Currency\Response;
use Psr\Http\Message\ResponseInterface;

class NewestRateResponse extends Response implements \App\Services\Currency\NewestRateResponse
{
    private $code;

    private $value;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        $content = $this->getContent();

        $this->code = $content->code;
        $this->value = $content->rates[0]->mid;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getInfo()
    {
        return [
            'type' => 'success',
            'rate' => [
                'code' => $this->code,
                'value' => $this->value,
            ],
        ];
    }
}