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
	 * @var Uvi
	 */
	protected $uvi;

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
		Uvi $uvi = null,
		float $clouds = null,
		float $visibility = null,
		Precipitation $precipitation = null
	): self {
		$weather = new self($minTemperature, $maxTemperature, $pressure, $humidity, $wind, $icon, $uvi, $clouds, $visibility, $precipitation);

		return $weather;
	}


	public function toArray(): array {
		return [
			'minTemperature' => $this->minTemperature->toArray(),
			'maxTemperature' => $this->maxTemperature->toArray(),
			'pressure' => $this->pressure->toArray(),
			'humidity' => $this->humidity,
			'wind' => $this->wind->toArray(),
			'icon' => $this->icon->toArray(),
			'uvi' => $this->uvi ? $this->uvi->toArray() : null,
			'clouds' => $this->clouds,
			'visibility' => $this->visibility,
			'precipitation' => $this->precipitation ? $this->precipitation->toArray() : null,
		];
	}


	protected function __construct(
		Temperature $minTemperature,
		Temperature $maxTemperature,
		Pressure $pressure,
		float $humidity,
		Wind $wind,
		Icon $icon,
		Uvi $uvi = null,
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
		$this->uvi = $uvi;
		$this->clouds = $clouds;
		$this->visibility = $visibility;
		$this->precipitation = $precipitation;
	}
}
