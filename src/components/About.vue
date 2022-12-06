<script setup>
	import { ref } from '@vue/reactivity'

	let openedAbout = ref(false);

	const showAbout = () => {
		openedAbout.value = true;
	}

	const closeAbout = () => {
		openedAbout.value = false;
	}
</script>

<template>
	<a href="#" @click="showAbout()">About</a>

	<div class="about-modal" v-show="openedAbout">
		<div class="about-modal__body">
			<p>Created: <a href="https://github.com/asboldyrev">Andrew Boldyrev</a></p>
			<p>Source code: <a href="https://github.com/asboldyrev/weather-app">GitHub</a></p>
			<p>Resources used:</p>
			<ul>
				<li>
					<a href="https://open-meteo.com" target="__blank">Open meteo</a> — weather data
				</li>
				<li>
					<a href="https://github.com/basmilius/weather-icons" target="__blank">Basmilius</a> — weather icons
				</li>
				<li>
					<a href="https://draculatheme.com/" target="__blank">Dracula</a> — theme
				</li>
				<li>
					<a href="https://ionic.io/ionicons" target="__blank">Ionicons</a> — system icons
				</li>
			</ul>
		</div>
		<div class="about-modal__footer">
			<a href="#" @click="closeAbout()">Close</a>
		</div>
	</div>
</template>

<style lang="scss" scoped>
	.about-modal {
		text-align: left;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		z-index: 9999;
		box-sizing: border-box;
		background-color: var(--current-line);
		border-radius: 10rem;

		&__body {
			padding: 10rem 20rem 0;
		}

		&__footer {
			text-align: center;
			border-top: 1px solid var(--comment);;
			padding: 10rem 20rem;

			a {
				text-decoration: none;
			}
		}
	}
</style>
