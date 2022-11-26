<?php

namespace App\Services\Weather\Entities;

use App\Exceptions\NotFoundIconIndex;
use Illuminate\Contracts\Support\Arrayable;

class Icon implements Arrayable
{
	/**
	 * @var int
	 */
	protected $index;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $day;

	/**
	 * @var string
	 */
	protected $night;


	public static function create(int $index) {
		$icon_trans = trans("icons.{$index}");

		if(is_array($icon_trans) && count($icon_trans)) {
			$icon = new self($index, $icon_trans);

			return $icon;
		}

		throw new NotFoundIconIndex($index);

	}


	public function toArray(): array {
		return [
			'index' => $this->index,
			'name' => $this->name,
			'description' => $this->description,
			'day' => $this->day,
			'night' => $this->night,
		];
	}


	protected function __construct(int $index, array $iconData) {
		$this->index = $index;
		$this->name = $iconData['name'];
		$this->description = $iconData['description'];
		$this->day = $iconData['day'];
		$this->night = $iconData['night'];
	}
}
