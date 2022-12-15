import { useWeatherStore } from '../stores/weather'
import { useAirQualityStore } from '../stores/airQuality'
import { useForecastStore } from '../stores/forecast'

export default () => {
	const weatherStore = useWeatherStore();
	const qualityStore = useAirQualityStore();
	const forecastStore = useForecastStore();

	weatherStore.update();
	qualityStore.update();
	forecastStore.update();
}
