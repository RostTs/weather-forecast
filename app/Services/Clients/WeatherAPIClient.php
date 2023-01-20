<?php

namespace App\Services\Clients;

use App\Exceptions\WeatherClientException;
use App\Models\City;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;

class WeatherAPIClient implements WeatherAPIInterface
{
    private const API_URI = 'WEATHER_API_URI';
    private const API_KEY = 'WEATHER_API_KEY';

    /**
     * OpenWeatherService constructor.
     *
     * @param Client $http
     */
    public function __construct(private Client $http)
    {}

    /**
     * OpenWeatherService constructor.
     *
     * @param City $city
     *
     * @return array
     *
     *  @throws WeatherClientException
     */
    public function getCurrentWeatherForCity(City $city): array
    {

        try {
            $request = $this->http->get(env(self::API_URI), [
                'query' => [
                    'q' => $city->name,
                    'key' =>  env(self::API_KEY),
                ]]);
            $response = json_decode($request->getBody()->getContents());
        } catch (ClientException | RequestException | ConnectException | ServerException  $e) {
            report($e->getMessage());
            throw new WeatherClientException($e->getMessage());
        }
        return [
            'temperature' => $response->current->temp_c,
            'wind' => $response->current->wind_kph,
            'pressure' => $response->current->pressure_mb,
            'clouds' => $response->current->cloud,
        ];
    }
}
