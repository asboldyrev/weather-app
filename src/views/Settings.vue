<script setup>
	import { ref, watch } from 'vue-demi';
import About from '../components/About.vue'
	import Search from '../components/Search.vue'
	import { useCityStore } from '../stores/city'
	import { useSettingsStore } from '../stores/settings'

	let cityStore = useCityStore();
	let settingsStore = useSettingsStore();

	const setTimezone = (event) => {
		settingsStore.setSetting('localTimezone', event.target.checked);
	}
</script>

<template>
	<div class="search">
		<Search />
	</div>
	<div class="current-city">
		<span class="current-city__label">Current City</span>: <span>{{ cityStore.getCity()?.name }} ({{ cityStore.getCity()?.country }})</span>
	</div>

	<label class="timezone">
		<input
			type="checkbox"
			id="timezone-input"
			class="timezone__input"
			@click="setTimezone"
			:checked="settingsStore.getSetting('localTimezone')"
		>
		<label for="timezone-input">Local timezone</label>
	</label>
	<div class="about">
		<About />
	</div>
</template>

<style lang="scss" scoped>
	.about {
		margin-top: 35rem;
		text-align: center;
		display: block;
	}

	.current-city {
		margin: 10rem 15rem;
		margin-left: 0;

		&__label {
			color: var(--cyan);
			font-weight: 600;
		}
	}

	.timezone {

	}
</style>
