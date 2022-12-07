import { defineStore } from "pinia";
import { ref } from "vue";

import { useCityStore } from './city'

export const useWeatherStore = defineStore('weather', () => {
	let city = useCityStore();

	const params = new URLSearchParams({
		latitude: city.getCity().latitude,
		longitude: city.getCity().longitude,
		hourly: [
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
		]
	});

	let weather = ref({});
	let icons = ref({});

	fetch('/icons.json')
		.then(response => response.json())
		.then(response => {
			icons.value = response;
		});

	const updateWeather = async () => {
		if (city.getCityField('latitude')) {
			await fetch(decodeURIComponent(`https://api.open-meteo.com/v1/forecast?${params.toString()}`))
				.then(response => response.json())
				.then(response => {
					weather.value = response;
				});
		}

		return weather.value;
	}

	const getWeather = () => {
		return weather.value;
	}

	const getIcon = (code) => {
		return icons.value[code] || undefined;
	}

	return {
		weather,
		getWeather,
		updateWeather,
		getIcon
	}
})
