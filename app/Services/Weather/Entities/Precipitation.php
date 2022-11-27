<?php

namespace App\Services\Weather\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Precipitation implements Arrayable
{
	/**
	 * @var Rain
	 */
	protected $rain;

	/**
	 * @var Snow
	 */
	protected $snow;

	/**
	 * @var Shower
	 */
	protected $shower;


	public static function create(Rain $rain = null, Snow $snow = null, Shower $shower = null): self {
		return new self($rain, $snow, $shower);
	}


	public function toArray() {
		return [
			'rain' => $this->rain,
			'snow' => $this->snow,
			'shower' => $this->shower,
		];
	}


	protected function __construct(Rain $rain = null, Snow $snow = null, Shower $shower = null) {
		if (!is_null($rain)) {
			$this->rain = $rain;
		}

		if (!is_null($snow)) {
			$this->snow = $snow;
		}

		if (!is_null($shower)) {
			$this->shower = $shower;
		}
	}
}
