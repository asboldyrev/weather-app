import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import { airQuality } from "../use/openMeteoProperties";
import { updateData } from "../use/update";
import { useCityStore } from './city'

export const useAirQualityStore = defineStore('airQuality', () => {
	const cityStore = useCityStore();

	const params = reactive({
		latitude: cityStore.city.latitude,
		longitude: cityStore.city.longitude,
		timezone: cityStore.timezone,
		start_date: cityStore.currentDate.format('YYYY-MM-DD'),
		end_date: cityStore.currentDate.format('YYYY-MM-DD'),
		hourly: airQuality(),
	});

	let _quality = ref({});

	async function update() {
		params.latitude = cityStore.getCityField('latitude');
		params.longitude = cityStore.getCityField('longitude');
		params.timezone = cityStore.timezone;

		updateData('https://air-quality-api.open-meteo.com/v1/air-quality', params, 'air-quality').then(result => _quality.value = result);
	}

	function getHourlyValue(name) {
		if (_quality.value?.hourly) {
			return _quality.value?.hourly[name][cityStore.currentHour];
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
