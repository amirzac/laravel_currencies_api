<?php

namespace App\Providers;

use App\Repositories\AverageRate\AverageRateRepository;
use App\Repositories\AverageRate\AverageRateRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AverageRateRepository::class, function () {
            return new AverageRateRepositoryEloquent(app());
        });
    }
}
