<?php

namespace App\Services\Currency;

use Psr\Http\Message\ResponseInterface;

abstract class Response
{
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        if($this->response->getStatusCode() !== 200) {
            throw new \LogicException('Bad response status');
        }
    }

    protected function getContent()
    {
        return \GuzzleHttp\json_decode($this->response->getBody()->getContents());
    }
}