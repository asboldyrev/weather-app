<?php

namespace App\Services;

class Weather
{
	public static function getData(array $data) {
		$forecast = OpenMeteo::forecast($data);
		$air_pollution = OpenMeteo::airPollution($data);

		$weather_data = [
			'place' => Nominatim::getPlace($data),
			'timezone' => self::getTimezone($forecast),
			'weather' => [
				'current' => self::getCurrentWeather($forecast, $air_pollution),
				'minutely' => [],
				'hourly' => [],
				'daily' => [],
				'alerts' => []
			]
		];

		return array_merge(self::generateBaseData($forecast, $air_pollution), $weather_data);
	}


	protected static function generateBaseData($forecast, $airPollution) {
		$wind_names = [
			'Штиль', 'Тихий', 'Лёгкий', 'Слабый', 'Умеренный', 'Свежий', 'Сильный', 'Крепкий',
			'Очень крепкий', 'Шторм', 'Сильный шторм', 'Жестокий шторм', 'Ураган',
		];

		$beaufort_index = self::getWindBeaufortIndex($forecast->current_weather->windspeed);

		$result = [
			'timestamp' => $forecast->current_weather->time,
			'sun' => [
				'uvIndex' => [
					'index' => round($airPollution->hourly->uv_index[0]),
					'value' => $airPollution->hourly->uv_index[0],
					'description' => self::getUvIndexDescription($airPollution->hourly->uv_index[0])
				],
			],
			'temperature' => [
				'temp' => $forecast->current_weather->temperature,
				//'feelsLike' => $forecast->feels_like,
				//'dewPoint' => $forecast->dew_point,
			],
			//'pressure' => $forecast->pressure,
			//'humidity' => $forecast->humidity,
			'wind' => [
				'speed' => $forecast->current_weather->windspeed,
				'degrees' => $forecast->current_weather->winddirection,
				//'gust' => $forecast->wind_gust,
				'index' => $beaufort_index,
				'direction' => self::getWindDirection($forecast->current_weather->winddirection),
				'name' => $wind_names[$beaufort_index],
			],
			//'clouds' => $forecast->clouds,
			//'description' => $forecast->weather[0]->description,
			'icon' => self::getWeatherIcon($forecast->current_weather->weathercode),
		];

		return $result;
	}


	protected static function getUvIndexDescription(float $uvIndex) {
		$uvIndex = round($uvIndex);

		if ($uvIndex <= 2) {
			return 'Низкий';
		}
		if ($uvIndex >= 3 && $uvIndex <= 5) {
			return 'Умеренный';
		}
		if ($uvIndex >= 6 && $uvIndex <= 7) {
			return 'Высокий';
		}
		if ($uvIndex >= 8 && $uvIndex <= 10) {
			return 'Очень высокий';
		}

		return 'Чрезмерный';
	}


	protected static function getWindDirection($degrees) {
		if ($degrees > 11.25 && $degrees < 33.75) {
			return 'ССВ';
		}

		if ($degrees > 33.75 && $degrees < 56.25) {
			return 'СВ';
		}

		if ($degrees > 56.25 && $degrees < 78.75) {
			return 'ВСВ';
		}

		if ($degrees > 78.75 && $degrees < 101.25) {
			return 'В';
		}

		if ($degrees > 101.25 && $degrees < 123.75) {
			return 'ВЮВ';
		}

		if ($degrees > 123.75 && $degrees < 146.25) {
			return 'ЮВ';
		}

		if ($degrees > 146.25 && $degrees < 168.75) {
			return 'ЮЮВ';
		}

		if ($degrees > 168.75 && $degrees < 191.25) {
			return 'Ю';
		}

		if ($degrees > 191.25 && $degrees < 213.75) {
			return 'ЮЮЗ';
		}

		if ($degrees > 213.75 && $degrees < 236.25) {
			return 'ЮЗ';
		}

		if ($degrees > 236.25 && $degrees < 258.75) {
			return 'ЗЮЗ';
		}

		if ($degrees > 258.75 && $degrees < 281.25) {
			return 'З';
		}

		if ($degrees > 281.25 && $degrees < 303.75) {
			return 'ЗСЗ';
		}

		if ($degrees > 303.75 && $degrees < 326.25) {
			return 'СЗ';
		}

		if ($degrees > 326.25 && $degrees < 348.75) {
			return 'ССЗ';
		}

		return 'С';
	}


	protected static function getTimezone($forecast) {
		return [
			'timezone' => $forecast->timezone,
			'timezoneOffset' => $forecast->utc_offset_seconds,
		];
	}


	protected static function getWindBeaufortIndex($windSpeed) {

		if ($windSpeed < 0.2) {
			return 0;
		}
		if ($windSpeed >= 0.2 && $windSpeed < 1.5) {
			return 1;
		}
		if ($windSpeed >= 1.5 && $windSpeed < 3.3) {
			return 2;
		}
		if ($windSpeed >= 3.3 && $windSpeed < 5.4) {
			return 3;
		}
		if ($windSpeed >= 5.4 && $windSpeed < 7.9) {
			return 4;
		}
		if ($windSpeed >= 7.9 && $windSpeed < 10.7) {
			return 5;
		}
		if ($windSpeed >= 10.7 && $windSpeed < 13.8) {
			return 6;
		}
		if ($windSpeed >= 13.8 && $windSpeed < 17.1) {
			return 7;
		}
		if ($windSpeed >= 17.1 && $windSpeed < 20.7) {
			return 8;
		}
		if ($windSpeed >= 20.7 && $windSpeed < 24.4) {
			return 9;
		}
		if ($windSpeed >= 24.4 && $windSpeed < 28.4) {
			return 10;
		}
		if ($windSpeed >= 28.4 && $windSpeed < 32.6) {
			return 11;
		}

		return 12;
	}


	protected static function getWeatherIcon($id) {
		if (config('icons.' . $id)) {
			return array_merge(compact('id'), config('icons.' . $id));
		}

		return [];
	}


	protected static function getCurrentWeather($forecast, $airPollution) {
		$sunrise = $forecast->daily->sunrise[0];
		$sunset = $forecast->daily->sunset[0];

		$result = [
			'sun' => [
				'isNight' => self::hasNight($sunset, $sunrise),
				'sunrise' => $sunrise,
				'sunset' => $sunset
			],
			'visibility' => $forecast->hourly->visibility[0],
			'airPollution' => AirPollution::getData($airPollution)
		];

		return $result;
	}


	protected static function hasNight($sunset, $sunrise) {
		$now = time();

		return $sunset < $now || $sunrise > $now;
	}
}
