import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import { dailyProperties, hourlyProperties } from "../use/openMeteoProperties";

import { useCityStore } from './city'
import { useSettingsStore } from './settings'

export const useWeatherStore = defineStore('weather', () => {
	const cityStore = useCityStore();
	const settingsStore = useSettingsStore();

	const params = reactive({
		latitude: cityStore.city.latitude,
		longitude: cityStore.city.longitude,
		timezone: settingsStore.timezone,
		hourly: hourlyProperties(),
		daily: dailyProperties(),
	});

	let _weather = ref({});
	let icons = ref({});

	fetch('/icons.json')
		.then(response => response.json())
		.then(response => {
			icons.value = response;
		});

	async function updateWeather() {
		if (cityStore.getCityField('latitude')) {
			params.latitude = cityStore.getCityField('latitude');
			params.longitude = cityStore.getCityField('longitude');
			params.timezone = settingsStore.timezone;

			await fetch(decodeURIComponent(`https://api.open-meteo.com/v1/forecast?${new URLSearchParams(params).toString()}`))
				.then(response => response.json())
				.then(response => {
					_weather.value = response;
				});
		}
	}

	function getIcon(code) {
		return icons.value[code] || undefined;
	}

	const weather = computed(() => {
		return _weather.value;
	});

	return {
		updateWeather,
		getIcon,
		weather,
	}
})
