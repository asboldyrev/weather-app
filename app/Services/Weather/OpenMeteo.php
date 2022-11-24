<?php

namespace App\Services\Weather;

use App\Services\Weather\Entities\Place;
use App\Services\Weather\Entities\Pollution;
use App\Services\Weather\Entities\Time;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Http;
use stdClass;

class OpenMeteo implements Arrayable
{
	/**
	 * @var Place
	 */
	protected $place;

	/**
	 * @var Time
	 */
	protected $time;

	/**
	 * @var array
	 */
	protected $pollutions = [];


	public function load(array $data): self {
		$forecast = $this->getForecast($data['lat'], $data['lon']);
		$pollution = $this->getPollution($data['lat'], $data['lon']);

		$this->place = Nominatim::getPlace($data['lat'], $data['lon']);
		$this->time = Time::create($forecast->timezone);
		$this->pollutions = $this->parsePollution($pollution->hourly, $pollution->hourly_units);

		return $this;
	}


	public function toArray(): array {
		return [
			'time' => $this->time->toArray(),
			'place' => $this->place->toArray(),
			//'current' => [
			//	'pollutions' => array_map(
			//		function(Pollution $pollution) {
			//			return $pollution->toArray();
			//		},
			//		$this->pollutions
			//	)
			//]
		];
	}


	protected function parsePollution(stdClass $pollutions, stdClass $units): array {
		$result = [];

		foreach($pollutions as $name => $pollution) {
			if($name == 'time' || is_null($pollution[0])) {
				continue;
			}

			$result[] = Pollution::create($name, $pollution[0], $units->{$name});
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
				'visibility'
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
		return Http::get($url, $data)->object();
	}
}
