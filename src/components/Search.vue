<script setup>
	import { ref } from "@vue/reactivity";
	import { watch } from "@vue/runtime-core";
	import { useAirQualityStore } from "../stores/airQuality";
	import { useCityStore } from '../stores/city'
	import { useForecastStore } from "../stores/forecast";
	import { useWeatherStore } from "../stores/weather";

	let cityStore = useCityStore();
	let weatherStore = useWeatherStore();
	let qualityStore = useAirQualityStore();
	let forecastStore = useForecastStore();

	let cities = ref([]);
	let search = ref('');

	watch(search, newValue => {
		if (newValue.length > 3) {
			fetch(`https://geocoding-api.open-meteo.com/v1/search?name=${search.value}&language=ru`)
				.then(response => response.json())
				.then(data => {
					cities.value = [];

					if(data?.results && data.results.length) {
						data.results.forEach(item => {
							cities.value.push(item);
						})
					}
				});
		} else {
			cities.value = [];
		}
	});

	function clearSearch() {
		search.value = '';
	}

	function selectCity(index) {
		cityStore.setCity(cities.value[index]);
		weatherStore.updateWeather();
		qualityStore.update();
		forecastStore.update();
		cities.value = [];
		search.value = '';
	}
</script>

<template>
	<div class="search">
		<div class="search__form">
			<input
				type="text"
				list="points"
				class="search__form_input"
				placeholder="London"
				:value="search"
				@input="e => search = e.target.value"
			>
			<div class="search__form_clear" v-if="search.length" @click="clearSearch">
				<svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
					<title>Close</title>
					<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"/>
				</svg>
			</div>
		</div>
		<div class="search__list" v-show="cities.length">
			<div class="option" v-for="(city, index) in cities" :key="index" @click="selectCity(index)">
				<img class="option__icon" :src="`https://hatscripts.github.io/circle-flags/flags/${city.country_code.toLowerCase()}.svg`" alt="">
				<div class="option__name">{{ city.name }}</div>
				<div class="option__admin1">{{ city.admin1 }}</div>
			</div>
		</div>
	</div>
</template>

<style lang="scss" scoped>

	.search {
		position: relative;

		&__form {
			display: grid;
			grid-template-columns: 1fr auto;
			grid-template-rows: 1fr;
			margin-bottom: 12rem;

			&_input {
				padding: 10rem 15rem;
				box-sizing: border-box;
				font-size: 16rem;
				border: 2px solid var(--comment);
				border-radius: 5rem;
				background-color: var(--current-line);
				color: var(--foreground);

				&::placeholder {
					color: var(--foreground);
					opacity: .6;
				}
			}

			&_clear {
				position: absolute;
				top: 10rem;
				right: 10rem;
			}
		}

		&__list {
			position: absolute;
			background-color: var(--current-line);
			border: 2px solid var(--comment);
			border-radius: 0 0 5rem 5rem;
			color: var(--foreground);
			top: 39rem;
			width: 100%;
			left: 0;
			max-height: 320rem;
			overflow-y: auto;
			z-index: 9999;

			.option {
				display: grid;
				grid-template-columns: auto 1fr auto;
				grid-template-rows: 1fr 1fr;
				border-bottom: 1px solid var(--comment);
				padding: 10rem 15rem;

				&:hover {
					background-color: var(--comment);
				}

				&__icon {
					grid-area: 1/1/3/2;
					max-width: 24rem;
					margin: auto 0;
					margin-right: 10rem;
				}

				&__name {
					grid-area: 1/2/2/2;
					height: 100%;
					margin: auto 0;
					line-height: baseline;
				}

				&__admin1 {
					grid-area: 2/2/3/3;
					font-size: 14rem;
					color: var(--cyan);
					margin-top: 3rem;
					opacity: .7;
				}
			}
		}
	}

</style>
