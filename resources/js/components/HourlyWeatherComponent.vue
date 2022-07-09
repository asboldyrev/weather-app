<template>
    <div class="row g-3 ms-2 me-2">
        <div class="col-1" v-for="index in 12" :key="index">
            <div>{{ getHourlyDate(index) }}</div>
            <img :src="getHourlyIconUrl(index)" alt="">
            <div class="text-center">{{ Math.round(hourly[index]?.temperature?.temp) }} °</div>
        </div>
    </div>
</template>

<script>
    import dayjs from 'dayjs'

    export default {
        props: {
            hourly: Array,
            extend: Boolean
        },
        methods: {
            getHourlyDate(index) {
                if(this?.hourly[index]?.timestamp) {
                    return dayjs.unix(this.hourly[index].timestamp).format('HH:mm')
                }
            },
            getHourlyIconUrl(index) {
                const weather = this.hourly[index];
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
