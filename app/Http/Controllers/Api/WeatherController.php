<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherResponse;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    protected $ttlWeatherCache = 10 * 60;

    protected $ttlNominatimCache = 24 * 60 * 60;


    public function show(Request $request) {
        $data = $request->all();
        $weather = $this->getWeatherData($data);
        $nominatim = $this->getNominatimData($data);
        $air_polution = $this->getAirPolutionData($data);

        $content = WeatherResponse::generate($weather, $air_polution, $nominatim);

        return response($content);
    }


    protected function getNominatimData(array $data) {
        $key_cache = 'nominatim-' . md5(json_encode($data));

        $content = Cache::get($key_cache);

        if(!$content) {
            $client = new Client([
                'base_uri' => 'https://nominatim.openstreetmap.org/',
            ]);

            $response = $client->get('reverse', [
                'query' => [
                    'lat' => $data['lat'],
                    'lon' => $data['lon'],
                    'format' => 'json',
                    'zoom' => 10
                ]
            ]);

            $body = $response->getBody();
            $content = $body->getContents();

            Cache::add($key_cache, $content, $this->ttlNominatimCache);
        }

        return json_decode($content);
    }


    protected function getWeatherData(array $data) {
        $key_cache = 'weather-' . md5(json_encode($data));

        $content = Cache::get($key_cache);

        if(!$content) {
            $client = new Client([
                'base_uri' => 'https://api.openweathermap.org/data/2.5/',
            ]);

            $response = $client->get('onecall', [
                'query' => array_merge($data, [ 'appid' => env('OWM_TOKEN') ])
            ]);

            $body = $response->getBody();
            $content = $body->getContents();

            Cache::add($key_cache, $content, $this->ttlWeatherCache);
        }

        return json_decode($content);
    }


    protected function getAirPolutionData(array $data) {
                $key_cache = 'aipPollution-' . md5(json_encode($data));

        $content = Cache::get($key_cache);

        if(!$content) {
            $client = new Client([
                'base_uri' => 'http://api.openweathermap.org/data/2.5/',
            ]);

            $response = $client->get('air_pollution', [
                'query' => array_merge($data, [ 'appid' => env('OWM_TOKEN') ])
            ]);

            $body = $response->getBody();
            $content = $body->getContents();

            Cache::add($key_cache, $content, $this->ttlWeatherCache);
        }

        return json_decode($content);
    }
}
