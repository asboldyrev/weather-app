<template>
	<div class="mt-4">
        <daily-forecast v-for="day in this.store.weather?.daily" :key="day.timestamp" :forecast="day"></daily-forecast>
	</div>
</template>

<script>
    import { useStore } from '../store'
    import DailyForecast from './DailyForecastComponent.vue'

    export default {
        setup() {
            const store = useStore()

            return { store }
        },
        components: {
            DailyForecast
        },
    }
</script>

<style lang="scss" scoped>

</style>
