<script setup>
	import { useWeatherStore } from '../../stores/weather';
	import { useSettingsStore } from '../../stores/settings';
	import Template from './Template.vue'
	import { computed } from 'vue'

	const weatherStore = useWeatherStore();

	const index = computed(() => {
		const speed = weatherStore.getHourlyValue('windspeed_10m') * 0.27777777778;

		if (speed < 0.2) {
			return 0;
		}

		const ranges = [
			[ 0.2, 1.5 ],
			[ 1.5, 3.3 ],
			[ 3.3, 5.4 ],
			[ 5.4, 7.9 ],
			[ 7.9, 10.7 ],
			[ 10.7, 13.8 ],
			[ 13.8, 17.1 ],
			[ 17.1, 20.7 ],
			[ 20.7, 24.4 ],
			[ 24.4, 28.4 ],
			[ 28.4, 32.6 ],
		];

		const index = ranges.findIndex(range => speed >= range[0] && speed < range[1]);

		if(index != -1) {
			return index + 1;
		}

		return 12;
	});

	const name = computed(() => {
		const names = [
			'Calm',
			'Light air',
			'Light breeze',
			'Gentle breeze',
			'Moderate breeze',
			'Fresh breeze',
			'Strong breeze',
			'Moderate gale',
			'Fresh gale',
			'Strong',
			'Storm',
			'Violent storm',
			'Hurricane',
		];

		return names[index.value];
	});

	const gust = computed(() => {
		return weatherStore.getHourlyValue('windgusts_10m') + ' ' + weatherStore.getHourlyUnit('windgusts_10m');
	});

	const speed = computed(() => {
		return weatherStore.getHourlyValue('windspeed_10m') + ' ' + weatherStore.getHourlyUnit('windspeed_10m');
	});

	const direction = computed(() => {
		const degrees = weatherStore.getHourlyValue('winddirection_10m');
		const directions = [ 'N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', ];
		const ranges = [
			[ 11.25, 33.75 ],
			[ 33.75, 56.25 ],
			[ 56.25, 78.75 ],
			[ 78.75, 101.25 ],
			[ 101.25, 123.75 ],
			[ 123.75, 146.25 ],
			[ 146.25, 168.75 ],
			[ 168.75, 191.25 ],
			[ 191.25, 213.75 ],
			[ 213.75, 236.25 ],
			[ 236.25, 258.75 ],
			[ 258.75, 281.25 ],
			[ 281.25, 303.75 ],
			[ 303.75, 326.25 ],
			[ 326.25, 348.75 ],
		];

		const directionIndex = ranges.findIndex(range => degrees >= range[0] && degrees < range[1]);

		if(directionIndex != -1) {
			return directions[directionIndex + 1];
		}

		return directions[0];

	});

</script>

<template>
	<Template :icon="`wind-beaufort-${index}`">
		<template #title>Wind</template>
		<template #description>{{ name }}. Gust: {{ gust }}</template>
		<template #value>{{ speed }} {{ direction }}</template>
	</Template>
</template>
