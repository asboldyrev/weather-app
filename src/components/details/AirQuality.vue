<script setup>
	import { useAirQualityStore } from '../../stores/airQuality';
	import Template from './Template.vue'
	import { computed } from 'vue'
	import { useI18n } from 'vue-i18n';

	const { t } = useI18n({ useScope: 'global' })

	const airQualityStore = useAirQualityStore();

	const index = computed(() => {
		return airQualityStore.getHourlyValue('uv_index');
	});

	const roundIndex = computed(() => {
		return Math.round(airQualityStore.getHourlyValue('uv_index'));
	});

	const name = computed(() => {
		const _index = roundIndex.value;

		if (_index <= 2) {
			return t('airQuality.uv-index.low');
		}

		if (_index >= 3 && _index <= 5) {
			return t('airQuality.uv-index.moderate');
		}

		if (_index >= 6 && _index <= 7) {
			return t('airQuality.uv-index.high');
		}

		if (_index >= 8 && _index <= 10) {
			return t('airQuality.uv-index.very');
		}

		return t('airQuality.uv-index.excess');
	});

</script>

<template>
	<Template :icon="roundIndex ? ('uv-index-' + roundIndex) : 'clear-day'">
		<template #title>{{ $t('interface.detail.uv-index') }}</template>
		<template #description>{{ index }}</template>
		<template #value>{{ name }}</template>
	</Template>
</template>
