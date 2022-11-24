<?php

namespace App\Services\Weather\Facades;

use Illuminate\Support\Facades\Facade;

class ForecastFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return 'ForecastWeather';
	}
}
