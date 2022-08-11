<template>
    <div class="row g-3 ms-1 me-1">
        <div class="col-auto">
            <div style="height:72px"></div>
            <div class="text-center">
                <img width="32px" src="/img/icons/colored-line/thermometer-celsius.svg" alt="">
            </div>
            <div class="text-center">
                <img width="32px" src="/img/icons/colored-line/raindrops.svg" alt="">
            </div>
        </div>
        <div class="col" v-for="index in 12" :key="index">
            <div>{{ getHourlyDate(index) }}</div>
            <img :src="getHourlyIconUrl(index)" alt="">
            <div class="text-center">{{ Math.round(store.weather.hourly[index]?.temperature?.temp) }} °</div>
            <div class="text-center">
                <small v-if="store.weather.hourly[index]?.rain" :title="(store.weather.hourly[index]?.pop * 100) + '%'">{{ store.weather.hourly[index]?.rain }}</small>
                <small v-else-if="store.weather.hourly[index]?.snow" :title="(store.weather.hourly[index]?.pop * 100) + '%'">{{ store.weather.hourly[index]?.snow }}</small>
                <small v-else>—</small>
            </div>
        </div>
    </div>
</template>

<script>
    import { useStore } from '../store'

    export default {
        setup() {
            const store = useStore()

            return { store }
        },
        methods: {
            getHourlyDate(index) {
                if(this.store.weather?.hourly[index]?.timestamp) {
                    return this.$dayjs.unix(this.store.weather.hourly[index].timestamp).format('HH:mm')
                }
            },
            getHourlyIconUrl(index) {
                const weather = this.store.weather.hourly[index];
                let filename = 'not-available';

                if(weather?.isDay) {
                    filename = weather?.icon?.day;
                } else if(weather?.icon?.night) {
                    filename = weather?.icon?.night;
                }

				return '/img/icons/colored-fill/' + filename + '.svg';
            }
        }
    }
</script>

<style lang="scss" scoped>
</style>
