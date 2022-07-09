<template>
    <div class="card bg-day text-white current">
        <div class="card-body">
            <div class="row h-100">
                <div class="col-6 h-100">
                    <div class="row">
                        <div class="col-6">
                            <h4>{{ place.locality }}</h4>
                            <p>{{ place.country }}</p>
                        </div>
                        <div class="col-6 text-end">
                            <h4>{{ time }}</h4>
                            <p>{{ date }}</p>
                        </div>
                    </div>
                    <div class="row h-100">
                        <div class="col-12 position-relative">
                            <h1 class="temperature">{{ temperature }} °</h1>
                            <p class="temperature_description">{{ weather.description }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="icon">
                        <img :src="iconUrl">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <alerts :alerts="alerts"></alerts>
                </div>
                <div class="col-6">
                    <air-quality class="mt-3 text-end" :pollution="weather?.airPollution"></air-quality>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Alerts from './AlertsComponent.vue'
    import AirQuality from './AirQualityComponent.vue'
    import dayjs from 'dayjs';

    export default {
  		props: {
            weather: {
                type: Object,
                required: true
            },
            alerts: {
                type: Object,
                required: true
            },
            place: {
                type: Object,
                required: true
            },
            extend: {
                type: Boolean,
                required: false
            },
        },
        components: {
            Alerts,
            AirQuality
        },
        computed: {
            date() {
                if(this.weather?.timestamp) {
                    return dayjs.unix(this.weather.timestamp).format('dddd, DD MMMM');
                }
            },
            time() {
                if(this.weather?.timestamp) {
                    return dayjs.unix(this.weather.timestamp).format('HH:mm');
                }
            },
            temperature() {
                if(this.weather.temperature?.temp) {
                    return Math.round(this.weather.temperature.temp);
                }
            },
            iconUrl() {
				let filename = 'not-available';

				if(this?.weather?.sun && this.weather.sun.isNight) {
                    filename = this.weather.icon.night;
				} else if(this?.weather?.sun) {
                    filename = this.weather.icon.day;
                }

				return '/img/icons/colored-fill/' + filename + '.svg';
			},
        }
    }
</script>

<style lang="scss" scoped>
    .current {
        background-color: #1c6cae!important;

        .icon {
            overflow: hidden;
            img {
                width: 20vw;
            }
        }

        .temperature {
            font-size: 10vw;
            transform: translate(2vw, 0vw);

            &_description {
                text-align: center;
                transform: translate(0, -1vw);
            }
        }
    }
</style>
