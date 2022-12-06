<script setup>
	import About from '../components/About.vue'
	import Search from '../components/Search.vue'
</script>

<template>
	<div class="search">
		<Search />
	</div>
	<div class="about">
		<About />
	</div>
</template>

<style lang="scss" scoped>
	.about {
		text-align: center;
		display: block;
	}
</style>
