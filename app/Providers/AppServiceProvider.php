<?php

namespace App\Providers;
use App\Services\WeatherService;
use GuzzleHttp\Client;
use App\Services\Clients\OpenWeatherAPIClient;
use App\Services\Clients\WeatherAPIClient;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Add new API clients here:
        $weatherClients = [
            new OpenWeatherAPIClient(new Client()),
            new WeatherAPIClient(new Client())
        ];

        $this->app->when(WeatherService::class)
            ->needs('$weatherClients')
            ->give($weatherClients);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
