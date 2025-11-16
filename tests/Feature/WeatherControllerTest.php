<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class WeatherControllerTest extends TestCase
{
    public function test_index_returns_view_with_weather_data()
    {
        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'main' => ['temp' => 28, 'humidity' => 60],
                'weather' => [['description' => 'sunny']],
                'wind' => ['speed' => 4]
            ], 200)
        ]);

        $response = $this->get('/?city=Manila');

        $response->assertStatus(200);
        $response->assertViewIs('weather.index');
        $response->assertViewHas('weather');
        $response->assertSee('Temperature: 28');
    }
}
