<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenMeteo
{
	protected static $weather;

	public static function forecast(array $data) {
		$_data = [
			'latitude' => $data['lat'],
			'longitude' => $data['lon'],
			'daily' => [
				'weathercode',
				'temperature_2m_max',
				'temperature_2m_min',
				'apparent_temperature_max',
				'apparent_temperature_min',
				'sunrise',
				'sunset',
				'precipitation_sum',
				'rain_sum',
				'showers_sum',
				'snowfall_sum',
				'windspeed_10m_max',
				'windgusts_10m_max',
				'winddirection_10m_dominant',
				'shortwave_radiation_sum'
			],
			'windspeed_unit' => 'ms',
			'timeformat' => 'unixtime',
			'timezone' => 'auto',
			'current_weather' => true,
			'hourly' => [
				'visibility'
			]
		];

		return self::request('https://api.open-meteo.com/v1/forecast', $_data);
	}


	public static function airPollution($data) {
		$_data = [
			'latitude' => $data['lat'],
			'longitude' => $data['lon'],
			'hourly' => [
				'pm10',
				'pm2_5',
				'carbon_monoxide',
				'nitrogen_dioxide',
				'sulphur_dioxide',
				'ozone',
				'aerosol_optical_depth',
				'dust',
				'uv_index',
				'uv_index_clear_sky',
				'alder_pollen',
				'birch_pollen',
				'grass_pollen',
				'mugwort_pollen',
				'olive_pollen',
				'ragweed_pollen'
			],
			'timezone' => 'auto',
			'timeformat' => 'unixtime'
		];

		return self::request('https://air-quality-api.open-meteo.com/v1/air-quality', $_data);
	}


	protected static function request(string $url, array $data) {
		return Http::get($url, $data)->object();
	}
}
