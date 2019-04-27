<?php

namespace App\Providers;

use App\Repositories\AverageRate\AverageRateRepositoryEloquent;
use App\Services\Currency\AverageRateCalculator;
use App\Services\Currency\Client;
use App\Services\Currency\NbpBank\Client as NbpClient;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class CurrencyClientServiceProvider extends ServiceProvider
{
    public function register():void
    {
        $this->app->singleton(Client::class, function (Application $app) {
            return new NbpClient(
                new \GuzzleHttp\Client(),
                new AverageRateCalculator(new AverageRateRepositoryEloquent(app())),
                new AverageRateRepositoryEloquent(app()),
                env('NBP_CURRENCY_TABLE', 'A'),
                env('NBP_CURRENCY_FORMAT', 'json')
            );
        });
    }
}
