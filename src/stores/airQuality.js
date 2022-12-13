import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import { airQuality } from "../use/openMeteoProperties";

import { useCityStore } from './city'
import { useSettingsStore } from './settings'

export const useAirQualityStore = defineStore('airQuality', () => {
	const cityStore = useCityStore();
	const settingsStore = useSettingsStore();

	const params = reactive({
		latitude: cityStore.city.latitude,
		longitude: cityStore.city.longitude,
		timezone: settingsStore.timezone,
		start_date: settingsStore.currentDate.format('YYYY-MM-DD'),
		end_date: settingsStore.currentDate.format('YYYY-MM-DD'),
		hourly: airQuality(),
	});

	let _quality = ref({});

	async function update() {
		if (cityStore.getCityField('latitude')) {
			params.latitude = cityStore.getCityField('latitude');
			params.longitude = cityStore.getCityField('longitude');
			params.timezone = settingsStore.timezone;

			await fetch(decodeURIComponent(`https://air-quality-api.open-meteo.com/v1/air-quality?${new URLSearchParams(params).toString()}`))
				.then(response => response.json())
				.then(response => {
					_quality.value = response;
				});
		}
	}

	function getHourlyValue(name) {
		if (_quality.value?.hourly) {
			return _quality.value?.hourly[name][settingsStore.currentHour];
		}
	}

	function getHourlyUnit(name) {
		if (_quality.value?.hourly_units) {
			return _quality.value?.hourly_units[name];
		}
	}

	const quality = computed(() => {
		return _quality.value;
	});

	return {
		update,
		getHourlyValue,
		getHourlyUnit,
		quality,
	}
})
