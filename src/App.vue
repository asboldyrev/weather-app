<script setup>
	import Menu from './components/Menu.vue'
	import { RouterView } from 'vue-router'
	import { onBeforeMount } from 'vue';
	import { updater } from './use/update';

	onBeforeMount(() => {
		updater();
		setInterval(updater, 1 * 60 * 1000);
	});
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
