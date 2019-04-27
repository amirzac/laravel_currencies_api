<?php

namespace App\Services\Currency\NbpBank;

use App\Entity\AverageRate;
use App\Repositories\AverageRate\AverageRateRepository;
use App\Services\Currency\AverageRateCalculator;
use GuzzleHttp\ClientInterface;
use http\Exception\InvalidArgumentException;
use App\Services\Currency\Client as CurrencyClientInterface;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Client implements CurrencyClientInterface
{
    private const DOMAIN = 'http://api.nbp.pl';

    private $httpClient;

    private $table;

    private $format;

    private $averageRateCalculator;

    private $averageRateRepository;

    private $allowedTables = ['A', 'B', 'C'];

    private $allowedFormats = ['json', 'xml'];

    public function __construct(
        ClientInterface $httpClient,
        AverageRateCalculator $averageRateCalculator,
        AverageRateRepository $averageRateRepository,
        string $table,
        string $format
    )
    {
        $this->httpClient = $httpClient;

        if(!in_array($table, $this->allowedTables)) {
            throw new InvalidArgumentException('Invalid table argument');
        }

        if(!in_array($format, $this->allowedFormats)) {
            throw new InvalidArgumentException('Invalid format argument');
        }

        $this->table = $table;
        $this->format = $format;
        $this->averageRateCalculator = $averageRateCalculator;
        $this->averageRateRepository = $averageRateRepository;
    }

    public function getList():\App\Services\Currency\GetListResponse
    {
        $response = $this->httpClient->request(
            'GET',
            sprintf(self::DOMAIN . "/api/exchangerates/tables/%s/?format=%s", $this->table, $this->format)
        );

        return new GetListResponse($response);
    }

    public function newestRate(string $code):\App\Services\Currency\NewestRateResponse
    {
        $response = $this->httpClient->request(
            'GET',
            sprintf(self::DOMAIN . "/api/exchangerates/rates/%s/%s/?format=%s", $this->table, $code, $this->format)
        );

        $response = new NewestRateResponse($response);

        $lastAverageValueForCurrentCode = Cache::get($this->getCacheKeyForLastAverageValue($code));
        if($lastAverageValueForCurrentCode !== $response->getValue()) {
            $averageRateModel = $this->averageRateCalculator->updateAverageValue($response->getCode(), $response->getValue());
            Cache::forever($this->getCacheKeyForNewestRate($code), new AverageRateResponse($averageRateModel));
            Cache::forever($this->getCacheKeyForLastAverageValue($code), $response->getValue());
        }

        return $response;
    }

    public function averageRate(string $code):\App\Services\Currency\AverageRateResponse
    {
        return Cache::get($this->getCacheKeyForNewestRate($code), function () use ($code) {
            /* @var $model AverageRate */
            $model = $this->averageRateRepository->findByField('code', $code)->first();

            if(is_null($model)) {
                throw new NotFoundHttpException('No information', null, 404);
            }

            return new AverageRateResponse($model);
        });
    }

    private function getCacheKeyForNewestRate(string $code):string
    {
        return "newestRate" . $code;
    }

    private function getCacheKeyForLastAverageValue(string $code):string
    {
        return 'lastAverageValue' . $code;
    }
}