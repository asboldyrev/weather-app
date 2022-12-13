<script setup>
	import { useAirQualityStore } from '../../stores/airQuality';
	import Template from './Template.vue'
	import { computed } from 'vue'

	const airQualityStore = useAirQualityStore();

	const index = computed(() => {
		return airQualityStore.getHourlyValue('uv_index');
	});

	const name = computed(() => {
		const _index = airQualityStore.getHourlyValue('uv_index');

		if (_index <= 2) {
			return 'Low';
		}

		if (_index >= 3 && _index <= 5) {
			return 'Moderate';
		}

		if (_index >= 6 && _index <= 7) {
			return 'High';
		}

		if (_index >= 8 && _index <= 10) {
			return 'Very';
		}

		return 'Excess';
	});

</script>

<template>
	<Template :icon="`uv-index${index ? ('-' + index) : ''}`">
		<template #title>UV Index</template>
		<template #description>{{ index }}</template>
		<template #value>{{ name }}</template>
	</Template>
</template>
