<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\WeatherServices;
use Illuminate\Support\Facades\Http;

class WeatherServiceTest extends TestCase
{
    public function test_get_weather_returns_array()
    {
        // Fake the HTTP request so no real API call happens
        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'main' => ['temp' => 30, 'humidity' => 70],
                'weather' => [['description' => 'clear sky']],
                'wind' => ['speed' => 5]
            ], 200)
        ]);

        $service = new WeatherServices();
        $result = $service->getWeatherByCity('Manila');

        // Assert it returns an array with main key
        $this->assertIsArray($result);
        $this->assertArrayHasKey('main', $result);
        $this->assertArrayHasKey('weather', $result);
        $this->assertArrayHasKey('wind', $result);

        // Optional: check temperature value
        $this->assertEquals(30, $result['main']['temp']);
    }

    public function test_get_weather_returns_error_on_failed_request()
    {
        // Fake a failed HTTP request
        Http::fake([
            'api.openweathermap.org/*' => Http::response([], 500)
        ]);

        $service = new WeatherServices();
        $result = $service->getWeatherByCity('InvalidCity');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Unable to fetch weather data.', $result['error']);
    }
}
