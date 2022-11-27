<?php

namespace App\Services\Weather\AbstractClasses;

use Illuminate\Contracts\Support\Arrayable;

abstract class PrecipitationAbstract implements Arrayable
{
	/**
	 * @var float
	 */
	protected $volume;

	/**
	 * @var string
	 */
	protected $unit;

	/**
	 * Probability of precipitation
	 *
	 * @var float
	 */
	protected $pop;


	/**
	 * @param float $volume
	 * @param string|null $unit
	 * @param float|null $pop Probability of precipitation
	 * @return void
	 */
	public static function create(float $volume, string $unit = null, float $pop = null) {
		return new self($volume, $unit, $pop);
	}


	protected function __construct(float $volume, string $unit = null, float $pop) {
		$this->volume = $volume;
		$this->pop = $pop;

		if (is_null($unit)) {
			$unit = config('units.length');
		}

		$this->unit = $unit;
	}


	public function toArray() {
		return [
			'volume' => $this->volume,
			'unit' => $this->unit,
			'pop' => $this->pop,
		];
	}
}
