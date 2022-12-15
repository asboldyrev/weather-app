<script setup>
	import { useWeatherStore } from '../../stores/weather';
	import Template from './Template.vue'
	import { computed } from 'vue'

	const weatherStore = useWeatherStore();

	const temperature = computed(() => {
		return weatherStore.getHourlyValue('temperature_2m') + ' ' + weatherStore.getHourlyUnit('temperature_2m');
	});

	const dewPoint = computed(() => {
		return weatherStore.getHourlyValue('dewpoint_2m') + ' ' + weatherStore.getHourlyUnit('dewpoint_2m');
	});

	const feelTemperature = computed(() => {
		return weatherStore.getHourlyValue('apparent_temperature') + ' ' + weatherStore.getHourlyUnit('apparent_temperature');
	});

</script>

<template>
	<Template icon="partly-cloudy-day-snow">
		<template #title>{{ temperature }}</template>
		<template #description v-if="weatherStore.getHourlyValue('dewpoint_2m') > 0">Dew point: {{ dewPoint }}</template>
		<template #value>Feel: {{ feelTemperature }}</template>
	</Template>
</template>
