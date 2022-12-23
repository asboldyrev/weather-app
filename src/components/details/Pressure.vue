<script setup>
	import { useWeatherStore } from '../../stores/weather';
	import Template from './Template.vue'
	import { computed } from 'vue'

	const weatherStore = useWeatherStore();

	const pressure = computed(() => {
		return Math.round(weatherStore.getHourlyValue('surface_pressure') / 1.33322) + ' mmHg';
	});

</script>

<template>
	<Template icon="barometer">
		<template #title>{{ $t('interface.detail.pressure') }}</template>
		<template #value>{{ pressure }}</template>
	</Template>
</template>
