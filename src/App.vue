<script setup>
	import Menu from './components/Menu.vue'
</script>

<template>
	<div class="layout">
		<div class="content">1</div>
		<Menu></Menu>
	</div>
</template>

<style lang="scss" scoped>
.layout {
	display: grid;
	grid-template-rows: 1fr 20vw;
	grid-auto-columns: 1fr;
	grid-auto-rows: 1fr;
	grid-auto-flow: row;
	justify-items: stretch;
	height: 100%;
}
</style>
