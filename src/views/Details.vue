<script setup>
	import { reactive } from "vue"

	let details = reactive([
		{
			title: 'Humidity',
			description: '',
			value: '54%',
			icon: 'colored-fill/humidity'
		},
		{
			title: 'Pressure',
			description: '',
			value: '1005 hPa',
			icon: 'colored-fill/barometer'
		},
		{
			title: 'Wind',
			description: 'Light. 3.55m/s',
			value: '2.58 m/s',
			icon: 'colored-fill/windsock'
		},
		{
			title: 'UV index',
			description: '0.79',
			value: 'Low',
			icon: 'colored-fill/uv-index-1'
		},
		{
			title: 'Sunset',
			description: '21:29',
			value: '3 hours',
			icon: 'colored-fill/sunset'
		},
		{
			title: 'Moon',
			description: '21:29',
			value: 'Now',
			icon: 'colored-fill/moonrise'
		},
	])

</script>

<template>
	<div class="details">
		<div class="detail__item" v-for="(detail, index) in details" :key="index">
			<div class="content">
				<div class="content__title">{{ detail.title }}</div>
				<div class="content__description">{{ detail.description }}</div>
				<div class="content__value">{{ detail.value }}</div>
			</div>
			<div class="icon">
				<img :src="'/icons/' + detail.icon + '.svg'" alt="">
			</div>
		</div>
	</div>
</template>

<style lang="scss" scoped>
.details {
	display: block;
	padding-bottom: 85rem;
}

.detail__item {
	display: grid;
	grid-template-columns: 1fr auto;
	grid-auto-columns: 1fr;
	grid-auto-rows: 1fr;
	gap: 0px 0px;
	grid-auto-flow: row;
	justify-items: stretch;
	margin-bottom: 10rem;
	background-color: var(--current-line);
	padding: 10rem;
	border-radius: 5rem;

	&:last-child {
		margin-bottom: 0;
	}

	.content {
		&__title {
			font-size: 24rem;
		}

		&__description {
			opacity: .8;
			font-size: 12rem;
			min-height: 12rem;
			margin-bottom: 10rem;
		}

		&__value {
			font-size: 16rem;
		}
	}

	.icon {
		max-height: 70rem;
		width: 70rem;
		margin-right: -8rem;
	}
}


</style>
