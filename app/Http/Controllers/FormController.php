<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;
use \App\Services\WeatherService;

class FormController extends Controller

{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View()
     */
    public function index()
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('form', $data);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse()
     */
    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("country_id", $request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse()
     */
    public function calculateForecast(Request $request, WeatherService $weatherService)
    {
        $this->validate(request(),['city' => 'required'],['city.required' => 'Unfortunately city is not found']);

        $city = City::find($request->city);
        $forecast = $weatherService->calculateForecastAverage($city);
        return redirect()->back()->with('message',['forecast' => $forecast,'city' => $city->name]);
    }
}
