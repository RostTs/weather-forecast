<?php

namespace App\Services;

use App\Models\Forecast;

class ForecastCreateService
{
    /**
     * Write code on Method
     *
     * @param array $forecast
     * @param int $cityId
     *
     * @return Forecast
     */
    public function getOrCreateForecast(array $forecast,int $cityId): Forecast
    {
        // 1 Hour back
        $date = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s"). ' - 1 hour'));
        //If forecast is older than 1 hour - creating new one
        $dbForecast = Forecast::where('city_id', $cityId)
            ->where('created_at', '>' ,$date)
            ->first();

        if(!$dbForecast){
            $dbForecast = Forecast::create([
                'city_id' => $cityId,
                'temperature' => $forecast['temperature'],
                'wind' => $forecast['wind'],
                'pressure' => $forecast['pressure'],
                'clouds' => $forecast['clouds']
            ]);
        }
        return $dbForecast;
    }
}
