<template>
    <div v-if="!isMobile" class="w-100">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="m-3">
                    <today-weather></today-weather>
                </div>

                <div class="m-3">
                    <hourly-weather></hourly-weather>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <forecast-weather></forecast-weather>
            </div>
        </div>
    </div>
</template>

<script>
    import TodayWeather from './components/TodayWeather.vue'
    import HourlyWeather from './components/HourlyWeatherComponent.vue'
    import ForecastWeather from './components/ForecastWeather.vue'

    import { useStore } from './store'
    import ruLocale from 'dayjs/locale/ru'
    import relativeTime from 'dayjs/plugin/relativeTime'

    const updateInterval = 5 * 60 * 1000;

    export default {
    name: 'App',
    components: {
        TodayWeather,
        HourlyWeather,
        ForecastWeather
    },
    setup() {
        const store = useStore()

        const width = document.documentElement.clientWidth;
        const height = document.documentElement.clientHeight;
        const isMobile = width < 1000 && width < height;

        store.updateData();

        return {
            isMobile,
            store
        }
    },
    beforeMount() {
        this.$dayjs.locale(ruLocale);
        this.$dayjs.extend(relativeTime);

        setInterval(this.store.updateData, updateInterval);
    }
}
</script>

<style lang="scss">
    datalist {
        appearance: none
    }
</style>
