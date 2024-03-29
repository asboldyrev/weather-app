<script setup>
	import { computed } from 'vue';
	import dayjs from 'dayjs';
	import { useCityStore } from '../stores/city'
	import { useWeatherStore } from '../stores/weather';
	import { useI18n } from 'vue-i18n';

	const { t } = useI18n({ useScope: 'global' })

	const cityStore = useCityStore();
	const weatherStore = useWeatherStore();

	const currentHour = computed(() => {
		if(cityStore.timezone) {
			return dayjs().tz(cityStore.timezone).hour();
		} else {
			return dayjs().hour();
		}
	});

	const temperature = computed(() => Math.round(weatherStore.weather?.hourly?.temperature_2m[currentHour.value]) + '°');

	const time = computed(() => dayjs(weatherStore.weather?.hourly?.time[currentHour.value]).format('HH:mm'));

	const date = computed(() => dayjs(weatherStore.weather?.hourly?.time[currentHour.value]).format('dd, D MMMM'));

	const icon = computed(() => {
		const name = weatherStore.isDay ? 'day' : 'night';

		return t(`icons.${weatherStore.getIconCode(currentHour.value)}.${name}`) || 'not-available';
	});

	const iconName = computed(() => t(`icons.${weatherStore.getIconCode(currentHour.value)}.name`));
</script>

<template>
	<div class="current">
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
			<img :src="`/icons/colored-fill/${(icon)}.svg`" alt="">
		</div>

		<div class="weather">
			<div class="weather__temperarure">{{ temperature }}</div>
			<div class="weather__name" v-t="iconName"></div>
		</div>
	</div>
</template>

<style lang="scss" scoped>
	.current {
		display: grid;
		grid-template-rows: 1fr 3fr 2fr;
	}
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
		max-height: 43vh;
		text-align: center;

		img {
			margin-top: -28rem;
			max-width: 340rem;
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
