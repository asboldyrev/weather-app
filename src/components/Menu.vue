<script setup>
</script>

<template>
	<div class="menu">
		<div>2.1</div>
		<div>2.2</div>
		<div>2.3</div>
	</div>
</template>

<style lang="scss">
	.menu {
		display: grid;
		grid-auto-columns: 1fr;
		grid-auto-rows: 1fr;
		grid-template-columns: repeat(3, 1fr);
		gap: 0px 0px;
		justify-items: stretch;

		div {
			background-color: var(--foreground);
		}
	}
</style>
