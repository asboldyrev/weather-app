<script setup>
	import { ref } from "@vue/reactivity";
	import dayjs from "../use/dayjs";
	import { useForecastStore } from "../stores/forecast";
	import { computed } from "vue";
	import { useCityStore } from "../stores/city";
	import { useI18n } from 'vue-i18n';

	const { t } = useI18n({ useScope: 'global' })

	const forecastStore = useForecastStore();
	const cityStore = useCityStore();

	let currentForecast = ref(0);

	function selectForecast(index) {
		currentForecast.value = index - 1;
	}

	const days = computed(() => {
		return forecastStore.forecast.daily?.time.length;
	});

	function date (index) {
		return dayjs(forecastStore.getDailyValue('time', index - 1), "YYYY-MM-DD").format('DD.MM')
	}

	function icon(index, field) {
		const code = forecastStore.getDailyValue('weathercode', index - 1);

		return t(`icons.${code}.${field}`);
	}

	function temperatureMax(index) {
		return Math.round(forecastStore.getDailyValue('temperature_2m_max', index - 1));
	}

	function temperatureMin(index) {
		return Math.round(forecastStore.getDailyValue('temperature_2m_min', index - 1));
	}

	function replaceName(name) {
		const names = {
			apparent_temperature_max: t('interface.forecast.feel-temperature-max'),
			apparent_temperature_min: t('interface.forecast.feel-temperature-min'),
			precipitation_sum: t('interface.forecast.precipitation'),
			rain_sum: t('interface.forecast.rain'),
			showers_sum: t('interface.forecast.showers'),
			snowfall_sum: t('interface.forecast.snowfall'),
			sunrise: t('interface.forecast.sunrise'),
			sunset: t('interface.forecast.sunset'),
			temperature_2m_max: t('interface.forecast.temperature-max'),
			temperature_2m_min: t('interface.forecast.temperature-min'),
			winddirection_10m_dominant: t('interface.forecast.wind-direction'),
			windgusts_10m_max: t('interface.forecast.wind-gusts'),
			windspeed_10m_max: t('interface.forecast.wind-speed'),
		};

		return names[name] || '';
	}

	const details = computed(() => {
		let details = [];
		const exclude = ['time', 'weathercode', 'shortwave_radiation_sum'];
		const skipUnit = ['sunrise', 'sunset'];

		for(name in forecastStore.forecast?.daily) {
			if(exclude.indexOf(name) == -1) {
				const unit = ' ' + forecastStore.getDailyUnit(name);
				let value = forecastStore.getDailyValue(name, currentForecast.value);

				if(name == 'sunrise' || name == 'sunset') {
					value = dayjs(value).tz(cityStore.timezone).format('HH:mm');
				}

				details.push({
					name: name,
					value: value + (skipUnit.indexOf(name) == -1 ? unit : '')
				});
			}
		}

		return details;
	});
</script>

<template>
	<div class="forecast">
		<div class="forecast__items">
			<div class="forecast__item" :class="{ 'active': currentForecast == (index-1) }" v-for="index in days" @click="selectForecast(index)">
				<div class="item__date">{{ date(index) }}</div>
				<div class="item__icon">
					<img :src="'/icons/colored-fill/' + icon(index, 'day') + '.svg'" alt="">
				</div>
				<div class="item__temperature">
					<span  class="item__temperature-max">{{ temperatureMax(index) }}</span>/<span class="item__temperature-min">{{ temperatureMin(index) }}</span>
				</div>
			</div>
		</div>

		<div class="forecast__detail">
			<div class="forecast__detail__item" v-for="(detailItem, detailIndex) in details" :key="detailIndex">
				<div class="forecast__detail__item__name">{{ replaceName(detailItem.name) }}</div>
				<div class="forecast__detail__item__value">{{ detailItem.value }}</div>
			</div>
		</div>
	</div>
</template>

<style lang="scss" scoped>
	.forecast {
		.forecast__items {
			overflow:auto;
			white-space:nowrap;

			.forecast__item {
				padding: 5rem 10rem;
				display: inline-block;
				text-align: center;
				margin: 10rem;

				&:first-child {
					margin-left: 0;
				}

				&:last-child {
					margin-right: 0;
				}

				&.active {
					background-color: var(--current-line);
					border-radius: 5rem;
				}

				.item__icon {
					max-height: 48rem;
					width: 48rem;
				}

				.item__temperature {
					&-min {
						color: var(--comment);
					}
				}
			}
		}

		.forecast__detail {
			margin-top: 12rem;

			&__item {
				box-sizing: border-box;
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				grid-auto-columns: 1fr;
				grid-auto-rows: 1fr;
				gap: 0px 0px;
				grid-auto-flow: row;
				justify-items: stretch;
				border-top: 1rem solid var(--comment);
				padding: 6rem 12rem;

				&:last-child {
					border-bottom: 1rem solid var(--comment);
				}

				&__value {
					text-align: right;
				}
			}
		}
	}
</style>
