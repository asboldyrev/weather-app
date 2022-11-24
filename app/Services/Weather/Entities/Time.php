<?php

namespace App\Services\Weather\Entities;

use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Contracts\Support\Arrayable;

class Time implements Arrayable
{
	/**
	 * @var string
	 */
	protected $timezone = 'UTC';

	/**
	 * @var integer
	 */
	protected $offset = 0;

	/**
	 * @var string
	 */
	protected $timeOffset = '00:00';


	public static function create(string $timezone):self {
		return new self($timezone);
	}


	public function toArray() {
		return [
			'timezone' => $this->timezone,
			'offset' => $this->offset,
			'timeOffset' => $this->timeOffset,
		];
	}


	protected function __construct(string $timezone) {
		$timezone = timezone_open($timezone);
		$date_time = new DateTimeImmutable('now', $timezone);

		$this->timezone = $timezone->getName();
		$this->offset = $date_time->getOffset();
		$this->timeOffset = $date_time->format('P');
	}
}
