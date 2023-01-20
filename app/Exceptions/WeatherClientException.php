<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class WeatherClientException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report(): void
    {
        Log::debug('Error with client');
    }
}
