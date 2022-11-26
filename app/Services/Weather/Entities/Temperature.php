<?php

namespace App\Services\Weather\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Temperature implements Arrayable
{
	/**
	 * @var float
	 */
	protected $value = 0;

	/**
	 * @var string
	 */
	protected $unit = '';


	public static function create(float $value, string $unit = null): self {
		$temperature = new self($value, $unit);

		return $temperature;
	}


	public function toArray() {
		return [
			'value' => $this->value,
			'unit' => $this->unit
		];
	}


	protected function __construct(float $value, string $unit = null) {
		$this->value = $value;

		if (is_null($unit)) {
			$unit = trans('units.metric.temperature');
		}

		$this->unit = $unit;
	}
}