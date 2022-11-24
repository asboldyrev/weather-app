<?php

namespace App\Services\Weather\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Wind implements Arrayable
{
	/**
	 * @var float
	 */
	protected $speed = 0;

	/**
	 * @var float
	 */
	protected $degress = 0;

	/**
	 * @var float|null
	 */
	protected $gust = 0;

	/**
	 * @var string
	 */
	protected $unit = '';

	/**
	 * @var integer
	 */
	protected $index = 0;

	/**
	 * @var string
	 */
	protected $direction = '';

	/**
	 * @var string
	 */
	protected $name = '';


	public static function create(float $speed, float $degress, string $unit = null, float $gust = null): self {
		$wind = new self($speed, $degress, $gust);

		if(is_null($unit)) {
			$wind->unit = trans('units.metric.speed');
		}

		return $wind;
	}


	public function toArray() {
		return [
			'speed' => $this->speed,
			'degress' => $this->degress,
			'gust' => $this->gust,
			'unit' => $this->unit,
			'index' => $this->index,
			'direction' => $this->direction,
			'name' => $this->name,
			'gust' => $this->gust,
		];
	}


	protected function __construct(float $speed, float $degress, float $gust = null) {
		$this->speed = $speed;
		$this->degress = $degress;
		$this->direction = $this->findDirection($degress);
		$this->index = $this->findBeaufortIndex($speed);
		$this->name = $this->findName();
		$this->gust = $gust;

		return $this;
	}


	protected static function findDirection(float $degrees): string  {
		$ranges = [
			[ 11.25, 33.75 ],
			[ 33.75, 56.25 ],
			[ 56.25, 78.75 ],
			[ 78.75, 101.25 ],
			[ 101.25, 123.75 ],
			[ 123.75, 146.25 ],
			[ 146.25, 168.75 ],
			[ 168.75, 191.25 ],
			[ 191.25, 213.75 ],
			[ 213.75, 236.25 ],
			[ 236.25, 258.75 ],
			[ 258.75, 281.25 ],
			[ 281.25, 303.75 ],
			[ 303.75, 326.25 ],
			[ 326.25, 348.75 ],
		];

		foreach($ranges as $index => $range){
			if($degrees >= $range[0] && $degrees < $range[1]) {
				return trans("wind.directions." . ($index + 1));
			}
		}

		return trans("wind.directions.0");
	}


	protected static function findBeaufortIndex(float $speed): int {
		if ($speed < 0.2) {
			return 0;
		}

		$ranges = [
			[ 0.2, 1.5 ],
			[ 1.5, 3.3 ],
			[ 3.3, 5.4 ],
			[ 5.4, 7.9 ],
			[ 7.9, 10.7 ],
			[ 10.7, 13.8 ],
			[ 13.8, 17.1 ],
			[ 17.1, 20.7 ],
			[ 20.7, 24.4 ],
			[ 24.4, 28.4 ],
			[ 28.4, 32.6 ],
		];

		foreach($ranges as $index => $range) {
			if ($speed >= $range[0] && $speed < $range[1]) {
				return $index + 1;
			}
		}

		return 12;
	}


	protected function findName() {
		return trans("wind.names.{$this->index}");
	}
}
