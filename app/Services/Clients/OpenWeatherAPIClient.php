<?php

namespace App\Services\Clients;

use App\Models\City;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use App\Exceptions\WeatherClientException;

class OpenWeatherAPIClient implements WeatherAPIInterface
{
    private const UNITS = 'metric';

    private const API_URI = 'OPEN_WEATHER_API_URI';
    private const API_KEY = 'OPEN_WEATHER_API_KEY';

    /**
     * OpenWeatherService constructor.
     *
     * @param Client $http
     */
    public function __construct(private Client $http)
    {}

    /**
     * @param City $city
     *
     * @return array
     *
     * @throws WeatherClientException
     */
    public function getCurrentWeatherForCity(City $city): array
    {
        try {
            $request = $this->http->get(env(self::API_URI), [
                'query' => [
                    'lat' => $city->latitude,
                    'lon' => $city->longitude,
                    'units' => self::UNITS,
                    'appid' =>  env(self::API_KEY),
                ]]);
                $response = json_decode($request->getBody()->getContents());
        } catch (ClientException | RequestException | ConnectException | ServerException  $e) {
            report($e->getMessage());
            throw new WeatherClientException($e->getMessage());
        }
        return [
            'temperature' => $response->current->temp,
            'wind' => $response->current->wind_speed,
            'pressure' => $response->current->pressure,
            'clouds' => $response->current->clouds,
        ];
    }
}
