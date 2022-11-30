<?php

namespace App\Services\Weather\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Pressure implements Arrayable
{
	/**
	 * @var float
	 */
	protected $value;

	/**
	 * @var string
	 */
	protected $unit;


	public static function create(float $value, string $unit = null): self {
		return new self($value, $unit);
	}


	public function toArray(): array {
		return [
			'value' => $this->value,
			'unit' => $this->unit,
		];
	}


	protected function __construct(float $value, string $unit = null) {
		$this->value = $value;

		if(is_null($unit)) {
			$unit = trans('units.metric.pressure');
		}
	}
}
