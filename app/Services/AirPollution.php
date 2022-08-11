<?php

namespace App\Services;

class AirPollution
{
    protected static $ranges = [
        'co' => [
            [0, 5000], [5000, 7500], [7500, 10000], [10000, 20000], [20000]
        ],
        'no2' => [
            [0,50], [50,100], [100,200], [200,400], [400]
        ],
        'o3' => [
            [0,60], [60,120], [120,180], [180,240], [240]
        ],
        'so2' => [
            [0,50], [50, 100], [100, 350], [350, 500], [500]
        ],
        'pm2_5' => [
            [0,15], [15,30], [30,55], [55,110], [110]
        ],
        'pm10' => [
            [0,25], [25,50], [50,90], [90,180], [180]
        ],
        'aqi' => [
            [1,2], [2,3], [3,4], [4,5], [5,6]
        ],
    ];


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
