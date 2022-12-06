<script setup>
	import { ref } from "@vue/reactivity";
	import { watch } from "@vue/runtime-core";
	import { useCityStore } from '../stores/city'

	let store = useCityStore();

	let cities = ref([]);
	let search = ref('');

	watch(search, newValue => {
		if (newValue.length > 3) {
			fetch(`https://geocoding-api.open-meteo.com/v1/search?name=${search.value}&language=ru`)
				.then(response => {
					return response.json();
				})
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


	const selectCity = (index) => {
		store.setCity(cities.value[index]);
		cities.value = [];
		search.value = '';
	}
</script>

<template>
	<div class="search">
		<div class="search__form">
			<input type="text" list="points" class="search__form__input" placeholder="London" v-model="search">
			<button type="button" class="search__form__button">Find</button>
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

			&__input {
				padding: 10rem 15rem;
				box-sizing: border-box;
				font-size: 16rem;
				border: 2px solid var(--comment);
				border-radius: 5rem 0rem 0rem 5rem;
				border-right: none;
				background-color: var(--current-line);
				color: var(--foreground);

				&::placeholder {
					color: var(--foreground);
					opacity: .6;
				}
			}

			&__button {
				padding: 5rem 10rem;
				box-sizing: border-box;
				font-size: 16rem;
				background-color: var(--comment);
				border: 2px solid var(--comment);
				color: var(--foreground);
				border-radius: 0rem 5rem 5rem 0rem;
				border-left: none;
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
