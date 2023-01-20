<?php

namespace App\Services\Clients;

use App\Exceptions\WeatherClientException;
use App\Models\City;

interface WeatherAPIInterface {

    /**
     * @param City $city
     *
     * @return array
     *
     * @throws WeatherClientException
     */
    public function getCurrentWeatherForCity(City $city): array;
}
