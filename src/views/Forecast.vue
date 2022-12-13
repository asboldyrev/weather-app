<script setup>
import { reactive, ref } from "@vue/reactivity";
	let currentForecast = ref(0);

	function selectForecast(index) {
		currentForecast.value = index;
	}

	let items = reactive([
		{
			date: 'Today',
			icon: 'cloudy',
			temperature: {
				min: '3°',
				max: '12°'
			},
			details: [
				{
					name: 'Wind',
					value: '3.75 m/s NE'
				},
				{
					name: 'Pressure',
					value: '1005 hPa'
				},
				{
					name: 'Humidity',
					value: '47 %'
				},
				{
					name: 'UV index',
					value: '5.6'
				},
			]
		},
		{
			date: 'Mon',
			icon: 'clear-day',
			temperature: {
				min: '3°',
				max: '12°'
			}
		},
		{
			date: 'Tue',
			icon: 'overcast-day-rain',
			temperature: {
				min: '3°',
				max: '12°'
			}
		},
		{
			date: 'Wed',
			icon: 'thunderstorms-rain',
			temperature: {
				min: '3°',
				max: '12°'
			}
		},
		{
			date: 'Thu',
			icon: 'partly-cloudy-day-fog',
			temperature: {
				min: '3°',
				max: '12°'
			}
		},
		{
			date: 'Fri',
			icon: 'cloudy',
			temperature: {
				min: '3°',
				max: '12°'
			}
		},
		{
			date: 'Sat',
			icon: 'cloudy',
			temperature: {
				min: '3°',
				max: '12°'
			}
		},
		{
			date: 'Sun',
			icon: 'cloudy',
			temperature: {
				min: '3°',
				max: '12°'
			}
		},
	])
</script>

<template>
	<div class="forecast">
		<div class="forecast__items">
			<div class="forecast__item" :class="{ 'active': currentForecast == index }" v-for="(item, index) in items" :key="index" @click="selectForecast(index)">
				<div class="item__date">{{ item.date }}</div>
				<div class="item__icon">
					<img :src="'/icons/colored-fill/' + item.icon + '.svg'" alt="">
				</div>
				<div class="item__temperature">
					<span  class="item__temperature-max">{{ item.temperature.max }}</span>/<span class="item__temperature-min">{{ item.temperature.min }}</span>
				</div>
			</div>
		</div>

		<div class="forecast__detail">
			<div class="forecast__detail__item" v-for="(detailItem, detailIndex) in items[currentForecast].details" :key="detailIndex">
				<div class="forecast__detail__item__name">{{ detailItem.name }}</div>
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
