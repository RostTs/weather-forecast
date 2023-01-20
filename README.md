## In order for this to work you need to follow these steps

1. Configure .env file (you can find example in .env.example)

    1.1 Configure your DB credentials
        F.e.
        
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=weather
        DB_USERNAME=root
        DB_PASSWORD=root
        
    1.2 Necessarily add credentials for weather apis like in .env.example - without them nothing is gonna work
    
        OPEN_WEATHER_API_URI=https://api.openweathermap.org/data/3.0/onecall
        OPEN_WEATHER_API_KEY=9123983013662283101b6fa34fe9f844
        
        WEATHER_API_URI=http://api.weatherapi.com/v1/current.json
        WEATHER_API_KEY=308cf6ed85b64127b33201227231901

2. Run migration
3. You can add your own weather API:
    3.1 Add your API credentials to .env
    3.2 Create APIClient class and implement WeatherAPIInterface
    
        class SomeAPIClient implements WeatherAPIInterface
     
    3.3 Add your API client in AppServiceProvider - register()
    
           public function register()
            {
                //Add new API clients here:
                 $weatherClients = [
                  new OpenWeatherAPIClient(new Client()),
                  new WeatherAPIClient(new Client()),
                  new SomeAPIClient(new Client())
                 ];

                 $this->app->when(WeatherService::class)
                    ->needs('$weatherClients')
                    ->give($weatherClients);
            }
     3.4 Specify forecast parameters in your SomeAPIClient same as in other clients
     
     3.5 The WeatherService will receive your client and will add data from client to calculations
     
     4.Run php artisan serve to start server
