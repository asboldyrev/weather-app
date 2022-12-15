<script setup>
	import { useWeatherStore } from '../../stores/weather';
	import Template from './Template.vue'
	import { computed } from 'vue'

	const weatherStore = useWeatherStore();

	const humidity = computed(() => {
		return weatherStore.getHourlyValue('relativehumidity_2m') + ' ' + weatherStore.getHourlyUnit('relativehumidity_2m');
	});

</script>

<template>
	<Template icon="humidity">
		<template #title>Humidity</template>
		<template #value>{{ humidity }}</template>
	</Template>
</template>
