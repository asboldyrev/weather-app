<script setup>
	import { useWeatherStore } from '../../stores/weather';
	import { useSettingsStore } from '../../stores/settings';
	import Template from './Template.vue'
	import { computed } from 'vue'

	const weatherStore = useWeatherStore();

	const pressure = computed(() => {
		//return weatherStore.getHourlyValue('surface_pressure') + ' ' + weatherStore.getHourlyUnit('surface_pressure');
		return Math.round(weatherStore.getHourlyValue('surface_pressure') / 1.33322) + ' mmHg';
	});

</script>

<template>
	<Template icon="barometer">
		<template #title>Pressure</template>
		<template #value>{{ pressure }}</template>
	</Template>
</template>
