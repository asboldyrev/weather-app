<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Weather\Facades\ForecastFacade as ForecastWeather;

class WeatherController extends Controller
{
	public function show(Request $request) {
		$data = $request->all();

		return response()->json(ForecastWeather::load($data));
	}
}
