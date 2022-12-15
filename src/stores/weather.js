import dayjs from "../use/dayjs";
import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import { hourlyWeatherProperties, dailyWeatherProperties } from "../use/openMeteoProperties";

import { useCityStore } from './city'
import { useSettingsStore } from './settings'

export const useWeatherStore = defineStore('weather', () => {
	const cityStore = useCityStore();
	const settingsStore = useSettingsStore();

	const params = reactive({
		latitude: cityStore.city.latitude,
		longitude: cityStore.city.longitude,
		timezone: cityStore.getCityField('timezone'),
		start_date: settingsStore.currentDate.format('YYYY-MM-DD'),
		end_date: settingsStore.currentDate.format('YYYY-MM-DD'),
		hourly: hourlyWeatherProperties(),
		daily: dailyWeatherProperties(),
		current_weather: true,
	});

	let _weather = ref({});
	let icons = ref({});

	fetch('/icons.json')
		.then(response => response.json())
		.then(response => {
			icons.value = response;
		});

	async function update() {
		if (cityStore.getCityField('latitude')) {
			params.latitude = cityStore.getCityField('latitude');
			params.longitude = cityStore.getCityField('longitude');
			params.timezone = cityStore.getCityField('timezone');

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

	function getHourlyValue(name) {
		if (weather.value?.hourly) {
			return weather.value?.hourly[name][settingsStore.currentHour];
		}
	}

	function getHourlyUnit(name) {
		if (weather.value?.hourly_units) {
			return weather.value?.hourly_units[name];
		}
	}

	const weather = computed(() => {
		return _weather.value;
	});

	const isDay = computed(() => {
		const currentTime = dayjs(weather.value?.current_weather?.time).tz(weather.value?.timezone, true);
		const sunriseTime = dayjs(weather.value?.daily?.sunrise[0]).tz(weather.value?.timezone, true);
		const sunsetTime = dayjs(weather.value?.daily?.sunset[0]).tz(weather.value?.timezone, true);

		return currentTime.isBetween(sunriseTime, sunsetTime);

	});

	return {
		update,
		getIcon,
		getHourlyValue,
		getHourlyUnit,
		weather,
		isDay
	}
})
