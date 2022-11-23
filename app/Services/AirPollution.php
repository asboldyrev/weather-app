<?php

namespace App\Services;

class AirPollution {

	protected static $ranges = [
		'co' => [
			[0, 5000], [5000, 7500], [7500, 10000], [10000, 20000], [20000]
		],
		'no2' => [
			[0, 50], [50, 100], [100, 200], [200, 400], [400]
		],
		'o3' => [
			[0, 60], [60, 120], [120, 180], [180, 240], [240]
		],
		'so2' => [
			[0, 50], [50, 100], [100, 350], [350, 500], [500]
		],
		'pm2_5' => [
			[0, 15], [15, 30], [30, 55], [55, 110], [110]
		],
		'pm10' => [
			[0, 25], [25, 50], [50, 90], [90, 180], [180]
		],
		'aqi' => [
			[1, 2], [2, 3], [3, 4], [4, 5], [5, 6]
		],
	];


	public static function getData($airPollution) {
		$pm10 = $airPollution->hourly->pm10[0];
		$pm2_5 = $airPollution->hourly->pm2_5[0];
		$co = $airPollution->hourly->carbon_monoxide[0];
		$no2 = $airPollution->hourly->nitrogen_dioxide[0];
		$so2 = $airPollution->hourly->sulphur_dioxide[0];
		$o3 = $airPollution->hourly->ozone[0];

		return [
			'aqi' => 0,
			'components' => [
				'co' => [
					'value' => $co,
					'index' => self::getIndex('co', $co)
				],
				//'no' => [
				//	'value' => $no,
				//	'index' => self::getIndex('no', $no)
				//],
				'no2' => [
					'value' => $no2,
					'index' => self::getIndex('no2', $no2)
				],
				'o3' => [
					'value' => $o3,
					'index' => self::getIndex('o3', $o3)
				],
				'so2' => [
					'value' => $so2,
					'index' => self::getIndex('so2', $so2)
				],
				//'pm2_5' => [
				//	'value' => $airPollution->components->pm2_5,
				//	'index' => AirPollution::getIndex('pm2_5', $airPollution->components->pm2_5)
				//],
				//'pm10' => [
				//	'value' => $airPollution->components->pm10,
				//	'index' => AirPollution::getIndex('pm10', $airPollution->components->pm10)
				//],
				//'nh3' => [
				//	'value' => $airPollution->components->nh3,
				//	'index' => AirPollution::getIndex('nh3', $airPollution->components->nh3)
				//]
			],
			'dt' => $airPollution->hourly->time[0]
		];
	}


	public static function getIndex(string $name, float $value) {
		$ranges = self::$ranges[$name] ?? [];

		foreach($ranges as $index => $range) {
			if(self::isRange($range, $value)) {
				return $index + 1;
			}
		}
	}


	protected static function isRange(array $range, float $value) {
		if(count($range) == 1) {
			return $value > $range[0];
		}

		if(count($range) == 2) {
			return $value >= $range[0] && $value < $range[1];
		}

		return false;
	}
}
