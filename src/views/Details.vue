<script setup>
	import Temperature from '../components/details/Temperature.vue'
	import Humidity from '../components/details/Humidity.vue'
	import Pressure from '../components/details/Pressure.vue'
	import Wind from '../components/details/Wind.vue'
	import AirQuality from '../components/details/AirQuality.vue'
</script>

<template>
	<div class="details">
		<!--<Temperature />-->
		<Humidity />
		<Pressure />
		<Wind />
		<AirQuality />
	</div>
</template>
