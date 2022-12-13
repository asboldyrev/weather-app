<script setup>
	import { ref, watch } from 'vue-demi';
	import About from '../components/About.vue'
	import Search from '../components/Search.vue'
	import { useCityStore } from '../stores/city'
	import { useSettingsStore } from '../stores/settings'
	import { useWeatherStore } from '../stores/weather';

	let cityStore = useCityStore();
	let settingsStore = useSettingsStore();
	let weatherStore = useWeatherStore()

	function setTimezone(event) {
		settingsStore.setTimezoneMode(event.target.checked);
		weatherStore.updateWeather();
	}
</script>

<template>
	<div class="settings">
		<div class="search">
			<Search />
		</div>

		<div class="settings">
			<div class="settings__item">
				<div class="settings__item_name">Current City</div>
				<div class="settings__item_value" v-if="cityStore.city?.id">
					{{ cityStore.city?.name }} ({{ cityStore.city?.country }})
				</div>
			</div>
			<div class="settings__item" :class="{ disabled: !cityStore.getCityField('timezone') }">
				<div class="settings__item_name">Timezone</div>
				<div class="settings__item_value">
					<div class="timezone">
						<span class="timezone__label_before">City</span>
						<input
							type="checkbox"
							class="timezone__input"
							@click="setTimezone"
							:checked="settingsStore.timezoneMode"
							:disabled="!cityStore.getCityField('timezone')"
						>
						<span class="timezone__label_after">Local</span>
					</div>
				</div>
			</div>
		</div>

		<div class="about">
			<About />
		</div>
	</div>
</template>

<style lang="scss" scoped>
	.search {
		margin-bottom: 24rem;
	}

	.settings {
		&__item {
			box-sizing: border-box;
			display: grid;
			grid-template-columns: 1fr auto;
			grid-auto-columns: 1fr;
			grid-auto-rows: 1fr;
			gap: 0px 0px;
			grid-auto-flow: row;
			justify-items: stretch;
			border-top: 1rem solid var(--comment);
			padding: 10rem 0;

			&:first-child {
				border: none;
			}

			&_name {
				color: var(--cyan);
				font-weight: 600;
			}

			&.disabled {
				opacity: .6;
			}
		}
	}


	.timezone {
		display: grid;
		grid-template-columns: repeat(3, auto);

		&__input {
			-webkit-appearance: none;
			-moz-appearance: none;
			-o-appearance: none;
			width: 40rem;
			height: 20rem;
			background-color:var(--foreground);
			border: 1rem solid var(--cyan);
			border-radius: 50rem;
			-webkit-box-shadow: inset -20rem 0rem 0rem 0rem var(--cyan);
			box-shadow: inset -20rem 0rem 0rem 0rem var(--cyan);
			-webkit-transition-duration: 200ms;
			transition-duration: 200ms;
			padding: 0;
			margin: 0 10rem;

			&:checked {
				-webkit-box-shadow: inset 20rem 0rem 0rem 1rem var(--orange);
				box-shadow: inset 20rem 0rem 0rem 1rem var(--orange);
				border: 1rem solid var(--orange);
			}
		}
	}

	.about {
		margin-top: 35rem;
		text-align: center;
		display: block;
	}
</style>
