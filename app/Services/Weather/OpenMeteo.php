<?php

namespace App\Services\Weather;

use App\Services\Weather\Entities\Icon;
use App\Services\Weather\Entities\Place;
use App\Services\Weather\Entities\Pollution;
use App\Services\Weather\Entities\Precipitation;
use App\Services\Weather\Entities\Pressure;
use App\Services\Weather\Entities\Temperature;
use App\Services\Weather\Entities\Time;
use App\Services\Weather\Entities\Weather;
use App\Services\Weather\Entities\Wind;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use stdClass;

class OpenMeteo implements Arrayable
{
	const TTL_CACHE = 10 * 60;

	/**
	 * @var Place
	 */
	protected $place;

	/**
	 * @var Time
	 */
	protected $time;

	/**
	 * @var array[]
	 */
	protected $pollutions = [];

	/**
	 * @var Weather
	 */
	protected $currentWeather;



	public function load(array $data): self {
		$forecast = $this->getForecast($data['lat'], $data['lon']);
		$pollution = $this->getPollution($data['lat'], $data['lon']);

		$this->place = Nominatim::getPlace($data['lat'], $data['lon']);
		$this->time = Time::create($forecast->timezone);
		$this->pollutions = $this->parsePollution($pollution->hourly, $pollution->hourly_units);
		$this->currentWeather = $this->parseCurrentWeather($forecast);

		return $this;
	}


	public function toArray(): array {
		return [
			'time' => $this->time->toArray(),
			'place' => $this->place->toArray(),
			'currentWeather' => $this->currentWeather->toArray(),
		];
	}


	protected function parseCurrentWeather(stdClass $forecast) {
		$temperature = Temperature::create($forecast->current_weather->temperature);
		$pressure = Pressure::create($forecast->hourly->surface_pressure[0]);
		$wind = Wind::create(
			$forecast->current_weather->windspeed,
			$forecast->current_weather->winddirection,
			null,
			$forecast->hourly->windgusts_10m[0]
		);
		$icon = Icon::create($forecast->current_weather->weathercode);

		return Weather::create(
			$temperature,
			$temperature,
			$pressure,
			$forecast->hourly->relativehumidity_2m[0],
			$wind,
			$icon,
			null,
			$forecast->hourly->cloudcover[0],
			$forecast->hourly->visibility[0]
		);
dd($forecast);
	}


	protected function parsePollution(stdClass $pollutions, stdClass $units): array {
		$result = [];
		$replace_names = [
			'co' => 'carbon_monoxide',
			'no2' => 'nitrogen_dioxide',
			'so2' => 'sulphur_dioxide',
			'o3' => 'ozone',
		];

		foreach($pollutions as $name => $pollution) {
			if($name == 'time' || is_null($pollution[0])) {
				continue;
			}

			$_name = mb_strtolower($name);

			$short_name = array_search($_name, $replace_names);
			if ($short_name) {
				$_name = $short_name;
			}

			$result[] = Pollution::create($_name, $pollution[0], $units->{$name});
		}

		return $result;
	}


	protected function getForecast(float $latitude, float $longitude) {
		$data = [
			'latitude' => $latitude,
			'longitude' => $longitude,
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
				'temperature_2m',
				'relativehumidity_2m',
				'dewpoint_2m',
				'apparent_temperature',
				'precipitation',
				'rain',
				'showers',
				'snowfall',
				'weathercode',
				'surface_pressure',
				'cloudcover',
				'visibility',
				'windspeed_10m',
				'winddirection_10m',
				'windgusts_10m',
				'soil_temperature_0cm',
				'soil_temperature_6cm',
				'soil_moisture_0_1cm',
				'soil_moisture_1_3cm',
				'soil_moisture_3_9cm',
			]
		];

		return $this->request('https://api.open-meteo.com/v1/forecast', $data);
	}


	protected function getPollution(float $latitude, float $longitude) {
		$data = [
			'latitude' => $latitude,
			'longitude' => $longitude,
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

		return $this->request('https://air-quality-api.open-meteo.com/v1/air-quality', $data);
	}


	protected function request(string $url, array $data) {
		$key_cache = 'open-meteo-' . md5(json_encode($data));

		$content = Cache::get($key_cache);

		if(!$content) {
			$content = Http::get($url, $data)->object();
			Cache::add($key_cache, $content, self::TTL_CACHE);
		}

		return $content;
	}
}
