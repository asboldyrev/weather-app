<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OpenMeteo;
use App\Services\Weather;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $ttlWeatherCache = 10 * 60;

    protected $ttlNominatimCache = 24 * 60 * 60;


    public function show(Request $request) {
        $data = $request->all();

        return response()->json(Weather::getData($data));
    }


    //protected function getWeatherData(array $data) {
    //    $key_cache = 'weather-' . md5(json_encode($data));

    //    $content = Cache::get($key_cache);

    //    if(!$content) {
    //        $client = new Client([
    //            'base_uri' => 'https://api.openweathermap.org/data/2.5/',
    //        ]);

    //        $response = $client->get('onecall', [
    //            'query' => array_merge($data, [ 'appid' => env('OWM_TOKEN') ])
    //        ]);

    //        $body = $response->getBody();
    //        $content = $body->getContents();

    //        Cache::add($key_cache, $content, $this->ttlWeatherCache);
    //    }

    //    return json_decode($content);
    //}


    //protected function getAirPolutionData(array $data) {
    //            $key_cache = 'aipPollution-' . md5(json_encode($data));

    //    $content = Cache::get($key_cache);

    //    if(!$content) {
    //        $client = new Client([
    //            'base_uri' => 'http://api.openweathermap.org/data/2.5/',
    //        ]);

    //        $response = $client->get('air_pollution', [
    //            'query' => array_merge($data, [ 'appid' => env('OWM_TOKEN') ])
    //        ]);

    //        $body = $response->getBody();
    //        $content = $body->getContents();

    //        Cache::add($key_cache, $content, $this->ttlWeatherCache);
    //    }

    //    return json_decode($content);
    //}
}
