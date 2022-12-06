<script setup>
	import { ref } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";

	let result = ref([]);
	let search = ref('');

	watch(search, newValue => {
		if (newValue.length > 3) {
			// request
		}
	});
</script>

<template>
	<div class="search">
		<input type="text" list="points" class="search__input" placeholder="London" v-model="search">
		<button type="button" class="search__button">Find</button>
		<div class="search__list" v-show="result.length">
			<div class="search__list_option" v-for="(item, index) in result" :key="index">{{ item.name }}</div>
		</div>
	</div>
</template>

<style lang="scss" scoped>

	.search {
		display: grid;
		grid-template-columns: 1fr auto;
		grid-template-rows: 1fr;
		max-height: 43rem;
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

		&__list {
			grid-column-end: span 2;
			background-color: var(--current-line);
			border: 2px solid var(--comment);
			border-radius: 0 0 5rem 5rem;
			color: var(--foreground);
			position: relative;
			top: -3rem;

			&_option {
				border-bottom: 1px solid var(--comment);
				padding: 10rem 15rem;

				&:hover {
					background-color: var(--comment);
				}
			}
		}
	}

</style>
