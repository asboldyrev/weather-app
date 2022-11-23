<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Nominatim
{
	public static function getPlace($data) {
		$nominatim = Nominatim::getData($data['lat'], $data['lon']);

		return [
			'lat' => floatval($nominatim->lat),
			'lon' => floatval($nominatim->lon),
			'locality' => $nominatim->address->village ?? $nominatim->address->town ?? $nominatim->address->city,
			'country' => $nominatim->address->country,
			'country_code' => $nominatim->address->country_code,
			'boundingBox' => $nominatim->boundingbox,
		];
	}


	public static function getData(float $latitude, float $longitude) {
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
