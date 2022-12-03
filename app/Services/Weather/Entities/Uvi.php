<?php

namespace App\Services\Weather\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Uvi implements Arrayable
{
	/**
	 * @var float
	 */
	protected $index;

	/**
	 * @var string
	 */
	protected $name;


	public static function create(float $index): self {
		return new self($index);
	}


	public function toArray(): array {
		return [
			'index' => $this->index,
			'name' => $this->name,
		];
	}


	protected function __construct(float $index) {
		$this->index = $index;
		$this->name = $this->getName();
	}


	protected function getName() {
		$uvIndex = round($this->index);

		if ($uvIndex <= 2) {
			return trans('uvi.low');
		}
		if ($uvIndex >= 3 && $uvIndex <= 5) {
			return trans('uvi.moderate');
		}
		if ($uvIndex >= 6 && $uvIndex <= 7) {
			return trans('uvi.high');
		}
		if ($uvIndex >= 8 && $uvIndex <= 10) {
			return trans('uvi.very');
		}

		return trans('uvi.excess');
	}
}
