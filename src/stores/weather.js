import dayjs from "../use/dayjs";
import { defineStore } from "pinia";
import { computed, reactive, ref } from "vue";
import { hourlyWeatherProperties, dailyWeatherProperties } from "../use/openMeteoProperties";
import { updateData } from '../use/update'
import { useCityStore } from './city'
import { getCurrentInstance } from 'vue'

export const useWeatherStore = defineStore('weather', () => {
	const cityStore = useCityStore();
	const root = getCurrentInstance();

	const params = reactive({
		latitude: cityStore.city.latitude,
		longitude: cityStore.city.longitude,
		timezone: cityStore.timezone,
		start_date: cityStore.currentDate.format('YYYY-MM-DD'),
		end_date: cityStore.currentDate.format('YYYY-MM-DD'),
		hourly: hourlyWeatherProperties(),
		daily: dailyWeatherProperties(),
		current_weather: true,
	});

	let _weather = ref({});

	async function update() {
		params.latitude = cityStore.getCityField('latitude');
		params.longitude = cityStore.getCityField('longitude');
		params.timezone = cityStore.getCityField('timezone');

		updateData('https://api.open-meteo.com/v1/forecast', params, 'weather').then(result => _weather.value = result);
	}

	function getIconCode(hour) {
		return _weather.value?.hourly?.weathercode[hour] || undefined;
	}

	function getHourlyValue(name) {
		if (weather.value?.hourly) {
			return weather.value?.hourly[name][cityStore.currentHour];
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
		getIconCode,
		getHourlyValue,
		getHourlyUnit,
		weather,
		isDay
	}
})
