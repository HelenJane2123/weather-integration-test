<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherServices;

class WeatherController extends Controller
{
    private WeatherServices $weatherService;

    public function __construct(WeatherServices $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index(Request $request)
    {
        $city = $request->query('city', 'Manila');
        try {
            $weather = $this->weatherService->getWeatherByCity($city);
        } catch (\Exception $e) {
            Log::error("There is an error fetching data: " . $e->getMessage());
            return ['error' => 'Unable to fetch weather data.'];
        }
        return view('weather.index', compact('weather', 'city'));
    }
}
