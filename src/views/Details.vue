<script setup>
	import dayjs from "dayjs";
	import { computed, reactive } from "vue"
	import { useSettingsStore } from "../stores/settings";
	import { useWeatherStore } from "../stores/weather";

	const settingsStore = useSettingsStore();
	const weatherStore = useWeatherStore();

	const currentHour = computed(() => {
		if(settingsStore.timezone) {
			return dayjs().tz(settingsStore.timezone).hour();
		} else {
			return dayjs().hour();
		}
	});

	const details = computed(() => {
		return [
			//{
			//	title: 'sunrise',
			//	value: weatherStore.weather?.daily?.sunrise[0],
			//},
			//{
			//	title: 'sunset',
			//	value: weatherStore.weather?.daily?.sunset[0],
			//},
			//{
			//	title: 'shortwave_radiation_sum',
			//	value: weatherStore.weather?.daily?.shortwave_radiation_sum[0],
			//},


			{
				title: 'Humidity',
				value: weatherStore.weather?.hourly?.relativehumidity_2m[currentHour.value] + ' %',
			},
			{
				title: 'Dew point',
				value: weatherStore.weather?.hourly?.dewpoint_2m[currentHour.value] + ' °',
			},
			{
				title: 'Apparent temperature',
				value: weatherStore.weather?.hourly?.apparent_temperature[currentHour.value] + ' °',
			},
			{
				title: 'Precipitation',
				value: weatherStore.weather?.hourly?.precipitation[currentHour.value] + ' mm',
			},
			{
				title: 'Rain',
				value: weatherStore.weather?.hourly?.rain[currentHour.value] + ' mm',
			},
			{
				title: 'Showers',
				value: weatherStore.weather?.hourly?.showers[currentHour.value] + ' mm',
			},
			{
				title: 'Snowfall',
				value: weatherStore.weather?.hourly?.snowfall[currentHour.value] + ' mm',
			},
			{
				title: 'Pressure',
				value: weatherStore.weather?.hourly?.surface_pressure[currentHour.value] + ' hPa',
			},
			{
				title: 'Cloudcover',
				value: weatherStore.weather?.hourly?.cloudcover[currentHour.value] + ' %',
			},
			{
				title: 'Visibility',
				value: weatherStore.weather?.hourly?.visibility[currentHour.value] + ' m',
			},
			{
				title: 'Windspeed',
				value: weatherStore.weather?.hourly?.windspeed_10m[currentHour.value] + ' m/s',
			},
			{
				title: 'Winddirection',
				value: weatherStore.weather?.hourly?.winddirection_10m[currentHour.value] + ' °',
			},
			{
				title: 'Windgusts',
				value: weatherStore.weather?.hourly?.windgusts_10m[currentHour.value] + ' m/s',
			},
		];
	});
</script>

<template>
	<div class="details">
		<div class="detail__item" v-for="(detail, index) in details" :key="index">
			<div class="content">
				<div class="content__title">{{ detail?.title }}</div>
				<div class="content__description">{{ detail?.description }}</div>
				<div class="content__value">{{ detail?.value }}</div>
			</div>
			<div class="icon" v-if="detail?.icon">
				<img :src="'/icons/' + detail?.icon + '.svg'" alt="">
			</div>
		</div>
	</div>
</template>

<style lang="scss" scoped>
.details {
	display: block;
	padding-bottom: 85rem;
}

.detail__item {
	position: relative;
	display: grid;
	grid-template-columns: 1fr auto;
	padding: 10rem;
	border-top: 1px solid var(--comment);
	box-sizing: border-box;

	&:first-child {
		border: none;
	}

	.content {
		&__title {
			font-size: 24rem;
		}

		&__description {
			opacity: .8;
			font-size: 12rem;
			min-height: 12rem;
			margin-bottom: 10rem;
		}

		&__value {
			font-size: 16rem;
		}
	}

	.icon {
		max-height: 70rem;
		width: 70rem;
		margin-right: -8rem;
	}
}


</style>
