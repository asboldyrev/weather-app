export function hourlyWeatherProperties() {
	return [
		'temperature_2m',
		'relativehumidity_2m',
		'dewpoint_2m',
		'apparent_temperature',
		'precipitation',
		'rain',
		'showers',
		'snowfall',
		'weathercode',
		'surface_pressure',
		'cloudcover',
		'visibility',
		'windspeed_10m',
		'winddirection_10m',
		'windgusts_10m',
	];
}

export function dailyWeatherProperties() {
	return [
		//'weathercode',
		//'temperature_2m_max',
		//'temperature_2m_min',
		//'apparent_temperature_max',
		//'apparent_temperature_min',
		'sunrise',
		'sunset',
		//'precipitation_sum',
		//'rain_sum',
		//'showers_sum',
		//'snowfall_sum',
		//'windspeed_10m_max',
		//'windgusts_10m_max',
		//'winddirection_10m_dominant',
		//'shortwave_radiation_sum',
	];
}

export function dailyForecastProperties() {
	return [
		'weathercode',
		'temperature_2m_max',
		'temperature_2m_min',
		'apparent_temperature_max',
		'apparent_temperature_min',
		'sunrise',
		'sunset',
		'precipitation_sum',
		'rain_sum',
		'showers_sum',
		'snowfall_sum',
		'windspeed_10m_max',
		'windgusts_10m_max',
		'winddirection_10m_dominant',
		'shortwave_radiation_sum',
	];
}

export function airQuality() {
	return [
		'pm10',
		'pm2_5',
		'carbon_monoxide',
		'nitrogen_dioxide',
		'sulphur_dioxide',
		'ozone',
		'aerosol_optical_depth',
		'dust',
		'uv_index',
		'uv_index_clear_sky',
		'european_aqi',
	]
}
