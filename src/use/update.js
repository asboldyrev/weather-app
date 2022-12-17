import { useWeatherStore } from '../stores/weather'
import { useAirQualityStore } from '../stores/airQuality'
import { useForecastStore } from '../stores/forecast'

const cachedInterval = 30 * 60 * 1000;

export function updater() {
	const weatherStore = useWeatherStore();
	const qualityStore = useAirQualityStore();
	const forecastStore = useForecastStore();

	weatherStore.update();
	qualityStore.update();
	forecastStore.update();
}

export async function updateData(url, params, storageName, force) {
	const localData = JSON.parse(localStorage.getItem(storageName));
	let result = {};

	if (localData && Date.now() - localData?.timestamp <= cachedInterval && !force) {
		result = localData.data;
		console.log(storageName + ' cache load');
	} else if (params.latitude) {
		await fetch(decodeURIComponent(`${url}?${new URLSearchParams(params).toString()}`))
			.then(response => response.json())
			.then(response => {
				result = response;
				localStorage.setItem(storageName, JSON.stringify({
					timestamp: Date.now(),
					data: response
				}));
				console.log(storageName + ' update');
			});
	}

	return result;
}
