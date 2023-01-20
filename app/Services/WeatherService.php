<?php

namespace App\Services;

use App\Services\Clients\WeatherAPIInterface;
use App\Models\City;
use App\Models\Forecast;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    private const CACHE_DURATION = 3600;

    /**
     * @param WeatherAPIInterface[] $weatherClients
     * @param ForecastCreateService $createService
     */
    public function __construct(private array $weatherClients, private ForecastCreateService $createService){}

    /**
     * Write code on Method
     *
     * @param City $city
     *
     * @return Forecast
     */
    public function calculateForecastAverage(City $city): Forecast
    {
        if(Cache::get($city->id)){
            return Cache::get($city->id);
        }

        $forecasts = [];
        $calculatedForecast = [];
        foreach ($this->weatherClients as $weatherClient){
            $forecast = $weatherClient->getCurrentWeatherForCity($city);

            $forecasts['temperature'][] = $forecast['temperature'];
            $forecasts['wind'][] = $forecast['wind'];
            $forecasts['pressure'][] = $forecast['pressure'];
            $forecasts['clouds'][] = $forecast['clouds'];
        }
        foreach ($forecasts as $key => $values){
            $calculatedForecast[$key] = round((array_sum($values)) / count($values),2);
        }

        $forecast = $this->createService->getOrCreateForecast($calculatedForecast, $city->id);

        Cache::put($city->id, $forecast, self::CACHE_DURATION);

        return $forecast;
    }
}
