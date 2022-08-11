<?php

namespace App\Services;

class OneWeather
{
    public static function generateCurrent($weatherData, $airPollution) {
        $result = self::generateBaseData($weatherData);

        $result['sun']['isNight'] = self::hasNight($weatherData->sunset, $weatherData->sunrise);
        $result['sun']['sunrise'] = $weatherData->sunrise;
        $result['sun']['sunset'] = $weatherData->sunset;
        $result['visibility'] = $weatherData->visibility;

        $result['airPollution'] = [
            'aqi' => $airPollution->main->aqi,
            'components' => [
                'co' => [
                    'value' => $airPollution->components->co,
                    'index' => AirPollution::getIndex('co', $airPollution->components->co)
                ],
                'no' => [
                    'value' => $airPollution->components->no,
                    'index' => AirPollution::getIndex('no', $airPollution->components->no)
                ],
                'no2' => [
                    'value' => $airPollution->components->no2,
                    'index' => AirPollution::getIndex('no2', $airPollution->components->no2)
                ],
                'o3' => [
                    'value' => $airPollution->components->o3,
                    'index' => AirPollution::getIndex('o3', $airPollution->components->o3)
                ],
                'so2' => [
                    'value' => $airPollution->components->so2,
                    'index' => AirPollution::getIndex('so2', $airPollution->components->so2)
                ],
                'pm2_5' => [
                    'value' => $airPollution->components->pm2_5,
                    'index' => AirPollution::getIndex('pm2_5', $airPollution->components->pm2_5)
                ],
                'pm10' => [
                    'value' => $airPollution->components->pm10,
                    'index' => AirPollution::getIndex('pm10', $airPollution->components->pm10)
                ],
                'nh3' => [
                    'value' => $airPollution->components->nh3,
                    'index' => AirPollution::getIndex('nh3', $airPollution->components->nh3)
                ]
            ],
            'dt' => $airPollution->dt
        ];

        return $result;
    }


    public static function generateMinutely($weatherData) {
        return [
            'dt' => $weatherData->dt,
            'precipitation' => $weatherData->precipitation,
        ];
    }


    public static function generateHourly($weatherData) {
        $result = self::generateBaseData($weatherData);

        $result['visibility'] = $weatherData->visibility;
        $result['pop'] = $weatherData->pop;
        $result['isDay'] = mb_stripos($weatherData->weather[0]->icon, 'd') !== false;

        if($weatherData->rain ?? false) {
            $result['rain'] = $weatherData->rain->{'1h'};
        }

        if($weatherData->snow ?? false) {
            $result['snow'] = $weatherData->snow->{'1h'};
        }

        return $result;
    }


    public static function generateDaily($weatherData) {
        $result = self::generateBaseData($weatherData);

        $result['sun']['isNight'] = self::hasNight($weatherData->sunset, $weatherData->sunrise);
        $result['sun']['sunrise'] = $weatherData->sunrise;
        $result['sun']['sunset'] = $weatherData->sunset;
        $result['moon'] = [
            'moonrise' => $weatherData->moonrise,
            'moonset' => $weatherData->moonset,
            'phase' => $weatherData->moon_phase,
            'icon' => self::getMoonIconName($weatherData->moon_phase),
        ];

        $result['pop'] = round($weatherData->pop * 100);
        $result['rain'] = $weatherData->rain ?? 0;

        $result['temperature']['temp'] = (array)$weatherData->temp;
        $result['temperature']['feelsLike'] = (array)$weatherData->feels_like;

        return $result;
    }


    protected static function generateBaseData($weatherData) {
        $wind_names = [
            'Штиль', 'Тихий', 'Лёгкий', 'Слабый', 'Умеренный', 'Свежий', 'Сильный', 'Крепкий',
            'Очень крепкий', 'Шторм', 'Сильный шторм', 'Жестокий шторм', 'Ураган',
        ];
        $beaufort_index = self::getWindBeaufortIndex($weatherData->wind_speed);

        $result = [
            'timestamp' => $weatherData->dt,
            'sun' => [
                'uvIndex' => [
                    'index' => round($weatherData->uvi),
                    'value' => $weatherData->uvi,
                    'description' => self::getUvIndexDescription($weatherData->uvi)
                ],
            ],
            'temperature' => [
                'temp' => $weatherData->temp,
                'feelsLike' => $weatherData->feels_like,
                'dewPoint' => $weatherData->dew_point,
            ],
            'pressure' => $weatherData->pressure,
            'humidity' => $weatherData->humidity,
            'wind' => [
                'speed' => $weatherData->wind_speed,
                'degrees' => $weatherData->wind_deg,
                'gust' => $weatherData->wind_gust,
                'index' => $beaufort_index,
                'direction' => self::getWindDirection($weatherData->wind_deg),
                'name' => $wind_names[$beaufort_index],
            ],
            'clouds' => $weatherData->clouds,
            'description' => $weatherData->weather[0]->description,
            'icon' => self::getWeatherIcon($weatherData->weather[0]->id),
        ];

        return $result;
    }


    protected static function getUvIndexDescription(float $uvIndex) {
        $uvIndex = round($uvIndex);

        if($uvIndex <= 2) {
            return 'Низкий';
        }
        if($uvIndex >= 3 && $uvIndex <= 5) {
            return 'Умеренный';
        }
        if($uvIndex >= 6 && $uvIndex <= 7) {
            return 'Высокий';
        }
        if($uvIndex >= 8 && $uvIndex <= 10) {
            return 'Очень высокий';
        }

        return 'Чрезмерный';
    }


    protected static function getWindBeaufortIndex($windSpeed) {

        if($windSpeed < 0.2) {
            return 0;
        }
        if($windSpeed >= 0.2 && $windSpeed < 1.5) {
            return 1;
        }
        if($windSpeed >= 1.5 && $windSpeed < 3.3) {
            return 2;
        }
        if($windSpeed >= 3.3 && $windSpeed < 5.4) {
            return 3;
        }
        if($windSpeed >= 5.4 && $windSpeed < 7.9) {
            return 4;
        }
        if($windSpeed >= 7.9 && $windSpeed < 10.7) {
            return 5;
        }
        if($windSpeed >= 10.7 && $windSpeed < 13.8) {
            return 6;
        }
        if($windSpeed >= 13.8 && $windSpeed < 17.1) {
            return 7;
        }
        if($windSpeed >= 17.1 && $windSpeed < 20.7) {
            return 8;
        }
        if($windSpeed >= 20.7 && $windSpeed < 24.4) {
            return 9;
        }
        if($windSpeed >= 24.4 && $windSpeed < 28.4) {
            return 10;
        }
        if($windSpeed >= 28.4 && $windSpeed < 32.6) {
            return 11;
        }

        return 12;
    }


    protected static function getWindDirection($degrees) {
        if($degrees > 11.25 && $degrees < 33.75) {
            return 'ССВ';
        }

        if($degrees > 33.75 && $degrees < 56.25) {
            return 'СВ';
        }

        if($degrees > 56.25 && $degrees < 78.75) {
            return 'ВСВ';
        }

        if($degrees > 78.75 && $degrees < 101.25) {
            return 'В';
        }

        if($degrees > 101.25 && $degrees < 123.75) {
            return 'ВЮВ';
        }

        if($degrees > 123.75 && $degrees < 146.25) {
            return 'ЮВ';
        }

        if($degrees > 146.25 && $degrees < 168.75) {
            return 'ЮЮВ';
        }

        if($degrees > 168.75 && $degrees < 191.25) {
            return 'Ю';
        }

        if($degrees > 191.25 && $degrees < 213.75) {
            return 'ЮЮЗ';
        }

        if($degrees > 213.75 && $degrees < 236.25) {
            return 'ЮЗ';
        }

        if($degrees > 236.25 && $degrees < 258.75) {
            return 'ЗЮЗ';
        }

        if($degrees > 258.75 && $degrees < 281.25) {
            return 'З';
        }

        if($degrees > 281.25 && $degrees < 303.75) {
            return 'ЗСЗ';
        }

        if($degrees > 303.75 && $degrees < 326.25) {
            return 'СЗ';
        }

        if($degrees > 326.25 && $degrees < 348.75) {
            return 'ССЗ';
        }

        return 'С';
	}


    protected static function getWeatherIcon($id) {
        if(config('icons.' . $id)) {
            return array_merge(compact('id'), config('icons.' . $id));
        }

        return [];
    }


    protected static function getMoonIconName($phase) {
        if($phase > 0 && $phase < 0.25) {
            return 'moon-waxing-crescent';
        }
        if($phase == 0.25) {
            return 'moon-first-quarter';
        }
        if($phase > 0.25 && $phase < 0.5) {
            return 'moon-waxing-gibbous';
        }
        if($phase == 0.5) {
            return 'moon-full';
        }
        if($phase > 0.5 && $phase < 0.75) {
            return 'moon-waning-gibbous';
        }
        if($phase == 0.75) {
            return 'moon-last-quarter';
        }
        if($phase > 0.75 && $phase < 1) {
            return 'moon-waning-crescent';
        }

        return 'moon-new';
    }


    protected static function hasNight($sunset, $sunrise) {
        $now = time();

        return $sunset < $now || $sunrise > $now;
    }
}
