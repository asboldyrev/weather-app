import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import { dailyForecastProperties } from "../use/openMeteoProperties";

import { useCityStore } from './city'
import { useSettingsStore } from './settings'

export const useForecastStore = defineStore('forecast', () => {
	const cityStore = useCityStore();
	const settingsStore = useSettingsStore();

	const params = reactive({
		latitude: cityStore.city.latitude,
		longitude: cityStore.city.longitude,
		timezone: settingsStore.timezone,
		start_date: settingsStore.currentDate.format('YYYY-MM-DD'),
		end_date: settingsStore.currentDate.add(10, 'day').format('YYYY-MM-DD'),
		daily: dailyForecastProperties(),
		current_weather: true,
	});

	let _forecast = ref({});
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
			params.timezone = settingsStore.timezone;

			await fetch(decodeURIComponent(`https://api.open-meteo.com/v1/forecast?${new URLSearchParams(params).toString()}`))
				.then(response => response.json())
				.then(response => {
					_forecast.value = response;
				});
		}
	}

	function getIcon(code) {
		return icons.value[code] || undefined;
	}

	function getDailyValue(name, day) {
		if (_forecast.value?.daily) {
			return _forecast.value?.daily[name][day];
		}
	}

	function getDailyUnit(name) {
		if (_forecast.value?.daily_units) {
			return _forecast.value?.daily_units[name];
		}
	}

	const forecast = computed(() => {
		return _forecast.value;
	});

	return {
		update,
		getIcon,
		getDailyValue,
		getDailyUnit,
		forecast,
	}
})
