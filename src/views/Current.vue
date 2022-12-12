<script setup>
	import { computed } from 'vue-demi';
	import { useCityStore } from '../stores/city'
	import { useWeatherStore } from '../stores/weather';
	import dayjs from 'dayjs';

	let cityStore = useCityStore();
	let weatherStore = useWeatherStore();

	let currentHour = dayjs().hour();

	const temperature = computed(() => {
		return Math.round(weatherStore.weather?.hourly?.temperature_2m[currentHour]) + '°';
	});

	const time = computed(() => {
		return dayjs(weatherStore.weather?.hourly?.time[currentHour]).format('HH:mm');
	});

	const date = computed(() => {
		return dayjs(weatherStore.weather?.hourly?.time[currentHour]).format('dd, D MMMM');
	});

	const icon = computed(() => {
		return weatherStore.getIcon(weatherStore.weather?.hourly?.weathercode[currentHour]);
	});
</script>

<template>
	<div class="header">
		<div class="header__country">
			<h2>{{ cityStore.getCityField('name') }}</h2>
			<h3>{{ cityStore.getCityField('country') }}</h3>
		</div>
		<div class="header__date">
			<p class="header__date-time">{{ time }}</p>
			<p class="header__date-date">{{ date }}</p>
		</div>
	</div>

	<div class="icon">
		<img :src="`/icons/colored-fill/${icon?.day || 'not-available'}.svg`" alt="">
	</div>

	<div class="weather">
		<div class="weather__temperarure">{{ temperature }}</div>
		<div class="weather__name">{{ icon?.name }}</div>
	</div>
</template>

<style lang="scss" scoped>
	.header {
		display: grid;
		grid-template-columns: repeat(2, 1fr);

		&__country {
			h2 {
				padding: 0;
				margin: 0;
				margin-top: 10rem;
			}
			h3 {
				padding: 0;
				margin: 0;
				margin-top: 4rem;
				font-weight: 100;
			}
		}

		&__date {
			text-align: right;

			&-time {
				font-size: 24rem;
				margin-bottom: 0;
				margin-top: 10rem;
			}

			&-date {
				margin-top: 6rem;
			}
		}
	}

	.icon {
		max-height: 320rem;

		img {
			margin-top: -50rem;
		}
	}

	.weather {
		text-align: center;

		&__temperarure {
			margin-top: 0;
			margin-left: 10rem;
			font-size: 120rem;
		}

		&__name {
			margin-top: 0;
			font-size: 20rem;
		}
	}
</style>
