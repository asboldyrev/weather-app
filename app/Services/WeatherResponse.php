<?php

namespace App\Services;

class WeatherResponse
{
    public static function generate(object $weather, object $airPolution, object $nominatim) {
        $weather_data = [
            'place' => [
                'lat' => floatval($nominatim->lat),
                'lon' => floatval($nominatim->lon),
                'locality' => $nominatim->address->village ?? $nominatim->address->town ?? $nominatim->address->city,
                'country' => $nominatim->address->country,
                'boundingBox' => $nominatim->boundingbox,
            ],
            'timezone' => [
                'timezone' => $weather->timezone,
                'timezoneOffset' => $weather->timezone_offset,
            ],
            'weather' => [
                'current' => OneWeather::generateCurrent($weather->current, $airPolution->list[0]),
                'minutely' => [],
                'hourly' => [],
                'daily' => [],
                'alerts' => self::filterAlerts($weather->alerts ?? [])
            ]
        ];

        foreach($weather->minutely ?? [] as $hourly_weather) {
            $weather_data['weather']['minutely'][] = OneWeather::generateMinutely($hourly_weather);
        }

        foreach($weather->hourly ?? [] as $hourly_weather) {
            $weather_data['weather']['hourly'][] = OneWeather::generateHourly($hourly_weather);
        }

        foreach($weather->daily ?? [] as $daily_weather) {
            $weather_data['weather']['daily'][] = OneWeather::generateDaily($daily_weather);
        }

        return $weather_data;
    }


    protected static function filterAlerts(array $alerts = null) {
        //if(!is_array($alerts)) {
        //    return [];
        //}

        //return array_values(
        //    array_filter($alerts, function($alert) {
        //        return preg_match('/[a-zA-Z]/', $alert->event) == false;
        //    })
        //);

        return $alerts;
    }
}
