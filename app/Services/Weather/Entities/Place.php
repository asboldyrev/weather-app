<?php

namespace App\Services\Weather\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Place implements Arrayable
{
	/**
	 * @var float
	 */
	protected $latitude;

	/**
	 * @var float
	 */
	protected $longitude;

	/**
	 * @var string
	 */
	protected $locality;

	/**
	 * @var string
	 */
	protected $country;

	/**
	 * @var string
	 */
	protected $countryCode;

	/**
	 * @var array
	 */
	protected $bound = [];


	public static function create(float $latitude, float $longitude, string $locality, string $country, string $countryCode, array $bound = []):self {
		return new self($latitude, $longitude, $locality, $country, $countryCode, $bound);
	}


	protected function __construct(float $latitude, float $longitude, string $locality, string $country, string $countryCode, array $bound = []) {
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->locality = $locality;
		$this->country = $country;
		$this->countryCode = $countryCode;
		$this->bound = $bound;
	}


	public function toArray():array {
		return [
			'coords' => [
				'latitude' => $this->latitude,
				'longitude' => $this->longitude,
				'bound' => $this->bound,
			],
			'locality' => $this->locality,
			'country' => $this->country,
			'countryCode' => $this->countryCode,
		];
	}
}
