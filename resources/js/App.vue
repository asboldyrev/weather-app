<template>
    <div v-if="!isMobile" class="w-100">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="m-3">
                    <today-weather :weather="weather.current" :alerts="weather.alerts" :place="place" extend></today-weather>
                </div>

                <div class="m-3">
                    <hourly-weather :hourly="weather.hourly" extend></hourly-weather>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <forecast-weather :forecast="weather.daily" extend></forecast-weather>
            </div>
        </div>
    </div>
</template>

<script>
    import TodayWeather from './components/TodayWeather.vue'
    import HourlyWeather from './components/HourlyWeatherComponent.vue'
    import ForecastWeather from './components/ForecastWeather.vue'

    import { weather } from './sdk'
    import ruLocale from 'dayjs/locale/ru'
    import relativeTime from 'dayjs/plugin/relativeTime'
    import dayjs from 'dayjs'

    export default {
    name: 'App',
    components: {
        TodayWeather,
        HourlyWeather,
        ForecastWeather
    },
    data() {
        return {
            isMobile: false,
            isOffline: false,
            place: {
                lat: 51.193535,
                lon: 82.242081,
                locality: '',
                country: '',
                boundingBox: []
            },
            timezone: {
                timezone: '',
                timezoneOffset: 0
            },
            weather: {
                current: {},
                hourly: [],
                daily: [],
                alerts: []
            },
            addreses: []
        }
    },
    methods: {
        updateData() {
            console.log('data updating');
            weather({
                lat: this.place.lat,
                lon: this.place.lon,
                appid: this.token,
                exclude: 'minutely',
                lang: 'ru',
                units: 'metric'
            }).then(response => {
                this.weather.current = response.weather.current;
                this.weather.hourly = response.weather.hourly;
                this.weather.daily = response.weather.daily;
                this.weather.alerts = response.weather.alerts;
                this.place = response.place;
                this.timezone = response.timezone;

                this.isOffline = false;
            })
            .catch(error => {
                console.log(error);
                this.isOffline = true;
            });
        }
    },
    beforeMount() {
        dayjs.locale(ruLocale);
        dayjs.extend(relativeTime)

        let width = document.documentElement.clientWidth,
            height = document.documentElement.clientHeight
        this.isMobile = width < 1000 && width < height;

        this.updateData();
        //setInterval(this.updateData, 0.1 * 60 * 1000);
    }
}
</script>

<style lang="scss">
    datalist {
        appearance: none
    }
</style>
