<?php

namespace App\Services\Weather;

use App\Services\Weather\Entities\Place;
use Illuminate\Support\Facades\Http;

class Nominatim {
	public static function getPlace(float $latitude, float $longitude):Place {
		$nominatim = Nominatim::getData($latitude, $longitude);

		return Place::create(
			$latitude,
			$longitude,
			$nominatim->address->village ?? $nominatim->address->town ?? $nominatim->address->city,
			$nominatim->address->country,
			$nominatim->address->country_code,
			$nominatim->boundingbox
		);
	}


	protected static function getData(float $latitude, float $longitude) {
		$params = [
			'lat' => $latitude,
			'lon' => $longitude,
			'format' => 'jsonv2',
			'zoom' => 16
		];

		$content = Http::get('https://nominatim.openstreetmap.org/reverse', $params)->body();

		return json_decode($content);
	}
}
