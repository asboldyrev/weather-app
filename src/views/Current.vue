<script setup>
</script>

<template>
	<div class="header">
		<div class="header__country">
			<h2>Беспаловский</h2>
			<h3>Россия</h3>
		</div>
		<div class="header__date">
			<p class="header__date-time">18:30</p>
			<p class="header__date-date">пн, 25 июня</p>
		</div>
	</div>

	<div class="icon">
		<!--<img src="/icons/colored-fill/cloudy.svg" alt="">-->
		<img src="/icons/colored-fill/overcast-night-rain.svg" alt="">
		<!--<img src="/icons/colored-fill/thunderstorms-night-extreme-rain.svg" alt="">-->
	</div>

	<div class="weather">
		<div class="weather__temperarure">28°</div>
		<div class="weather__name">Дождь</div>
	</div>
</template>

<style lang="scss" scoped>
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
		max-height: 320rem;

		img {
			margin-top: -50rem;
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
