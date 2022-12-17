import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import { dailyForecastProperties } from "../use/openMeteoProperties";
import { updateData } from "../use/update";
import { useCityStore } from './city'

export const useForecastStore = defineStore('forecast', () => {
	const cityStore = useCityStore();

	const params = reactive({
		latitude: cityStore.city.latitude,
		longitude: cityStore.city.longitude,
		timezone: cityStore.timezone,
		start_date: cityStore.currentDate.format('YYYY-MM-DD'),
		end_date: cityStore.currentDate.add(10, 'day').format('YYYY-MM-DD'),
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
		params.latitude = cityStore.getCityField('latitude');
		params.longitude = cityStore.getCityField('longitude');
		params.timezone = cityStore.timezone;

		updateData('https://api.open-meteo.com/v1/forecast', params, 'forecast').then(result => _forecast.value = result);
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
