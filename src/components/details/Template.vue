<script setup>
	const props = defineProps(['icon'])
</script>

<template>
	<div class="detail__item">
		<div class="content">
			<div class="content__title">
				<slot name="title"></slot>
			</div>
			<div class="content__description">
				<slot name="description"></slot>
			</div>
			<div class="content__value">
				<slot name="value"></slot>
			</div>
		</div>
		<div class="icon" v-if="icon">
			<img :src="'/icons/colored-fill/' + icon + '.svg'" alt="">
		</div>
	</div>
</template>

<style lang="scss" scoped>
	.detail__item {
		position: relative;
		display: grid;
		grid-template-columns: 1fr auto;
		padding: 10rem;
		border-top: 1px solid var(--comment);
		box-sizing: border-box;

		&:first-child {
			border: none;
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
