<?php

namespace App\Services\Weather\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Weather implements Arrayable
{

	/**
	 * @var Temperature
	 */
	protected $minTemperature;

	/**
	 * @var Temperature
	 */
	protected $maxTemperature;

	/**
	 * @var Pressure
	 */
	protected $pressure;

	/**
	 * @var float
	 */
	protected $humidity;

	/**
	 * @var Wind
	 */
	protected $wind;

	/**
	 * @var Icon
	 */
	protected $icon;

	/**
	 * @var Time
	 */
	protected $time;

	/**
	 * @var float|null
	 */
	protected $clouds;

	/**
	 * @var float|null
	 */
	protected $visibility;

	/**
	 * @var Precipitation|null
	 */
	protected $precipitation;


	public static function create(
		Temperature $minTemperature,
		Temperature $maxTemperature,
		Pressure $pressure,
		float $humidity,
		Wind $wind,
		Icon $icon,
		Time $time,
		float $clouds = null,
		float $visibility = null,
		Precipitation $precipitation = null
	): self {
		$weather = new self($minTemperature, $maxTemperature, $pressure, $humidity, $wind, $icon, $time, $clouds, $visibility, $precipitation);

		return $weather;
	}


	public function toArray(): array {
		return [
			'minTemperature' => $this->minTemperature,
			'maxTemperature' => $this->maxTemperature,
			'pressure' => $this->pressure,
			'humidity' => $this->humidity,
			'wind' => $this->wind,
			'icon' => $this->icon,
			'time' => $this->time,
			'clouds' => $this->clouds,
			'visibility' => $this->visibility,
			'precipitation' => $this->precipitation,
		];
	}


	protected function __construct(
		Temperature $minTemperature,
		Temperature $maxTemperature,
		Pressure $pressure,
		float $humidity,
		Wind $wind,
		Icon $icon,
		Time $time,
		float $clouds = null,
		float $visibility = null,
		Precipitation $precipitation = null
	) {
		$this->minTemperature = $minTemperature;
		$this->maxTemperature = $maxTemperature;
		$this->pressure = $pressure;
		$this->humidity = $humidity;
		$this->wind = $wind;
		$this->icon = $icon;
		$this->time = $time;
		$this->clouds = $clouds;
		$this->visibility = $visibility;
		$this->precipitation = $precipitation;
	}
}
