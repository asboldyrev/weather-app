<?php

namespace App\Services\Weather\Entities;

use Illuminate\Contracts\Support\Arrayable;

class CurrentWeather implements Arrayable
{
	/**
	 * @var Weather
	 */
	protected $weather;

	/**
	 * @var Time
	 */
	protected $time;


	public static function create(Weather $weather, Time $time): self {
		return new self($weather, $time);
	}


	public function toArray(): array {
		return [
			'weather' => $this->weather,
			'time' => $this->time,
		];
	}


	protected function __construct(Weather $weather, Time $time) {
		$this->weather = $weather;
		$this->time = $time;
	}
}
