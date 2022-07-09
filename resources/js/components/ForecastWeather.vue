<template>
	<div class="mt-4">
        <daily-forecast v-for="day in forecast" :key="day.timestamp" :forecast="day"></daily-forecast>
	</div>
</template>

<script>
    import DailyForecast from './DailyForecastComponent.vue'
export default {
	props: {
        forecast: Object
    },
    components: {
        DailyForecast
    },
}
</script>

<style lang="scss" scoped>

</style>
