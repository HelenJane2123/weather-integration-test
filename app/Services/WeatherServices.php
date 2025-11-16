<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherServices
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENWEATHER_API_KEY', '');
        if (empty($this->apiKey)) {
            throw new \Exception("OpenWeather API key is missing in .env");
        }
    }

    public function getWeatherByCity(string $city, string $country = 'PH'): array
    {
        $baseUrl = env('OPENWEATHER_BASE', '');
        if (empty($baseUrl)) {
            Log::error("OpenWeather base URL is missing in .env");
            return ['error' => 'Weather service not configured.'];
        }

        try {
            $response = Http::timeout(5)->get($baseUrl, [
                'q' => $city . ',' . $country,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);

            if ($response->failed()) {
                throw new \Exception("API request failed with status: ".$response->status());
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error("Weather API Error: " . $e->getMessage());
            return ['error' => 'Unable to fetch weather data.'];
        }
    }
}
