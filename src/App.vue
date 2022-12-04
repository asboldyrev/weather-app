<script setup>
	import Menu from './components/Menu.vue'
	import { RouterView } from 'vue-router'
</script>

<template>
	<div class="layout">
		<div class="content">
			<RouterView />
		</div>
		<Menu></Menu>
	</div>
</template>

<style lang="scss" scoped>
.content {
	box-sizing: border-box;
	padding: 10rem 10rem 0;
	margin-bottom: 75rem;
}
</style>
