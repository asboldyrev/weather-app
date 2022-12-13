<script setup>
	import Menu from './components/Menu.vue'
	import { RouterView } from 'vue-router'

	import { useWeatherStore } from './stores/weather'
	import { onBeforeMount } from 'vue';

	let store = useWeatherStore();

	onBeforeMount(store.updateWeather);
</script>

<template>
	<div class="container">
		<RouterView class="container__view" />
		<Menu class="container__nav" />
	</div>

</template>

<style lang="scss" scoped>
	.container {
		display: grid;
		grid-template-rows: auto 1fr;
		box-sizing: border-box;

		&__view {
			overflow: hidden;
			overflow-y: auto;
			max-height: calc(100vh - 75rem);
			min-height: calc(100vh - 75rem);
			padding: 10rem 10rem 0;
		}
	}
</style>
