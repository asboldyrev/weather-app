<?php

namespace App\Services\Weather\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Sun implements Arrayable
{
	/**
	 * @var int|null
	 */
	protected $sunrise;

	/**
	 * @var int|null
	 */
	protected $sunset;

	/**
	 * @var boolean
	 */
	protected $isNight = false;


	public static function create(int $sunrise, int $sunset): self {
		return new self($sunrise, $sunset);
	}


	public function toArray() {
		return [
			'sunrise' => $this->sunrise,
			'sunset' => $this->sunset,
			'isNight' => $this->isNight,
		];
	}


	protected function __construct(int $sunrise, int $sunset) {
		$this->sunrise = $sunrise;
		$this->sunset = $sunset;
		$this->isNight = $this->hasNight();
	}


	protected function hasNight() {
		$now = time();

		return $this->sunset < $now || $this->sunrise > $now;
	}
}
