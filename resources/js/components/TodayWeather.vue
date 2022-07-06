<template>
    <div v-if="extend" class="m-3" :class="{ 'today__extended': extend }">
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card bg-day text-white">
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
                                        <p class="temperature-text">{{ weather.description }}</p>
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
                            <div class="col-6"><alert-component :alerts="alerts"></alert-component></div>
                            <div class="col-6">
                                <air-quality class="mt-3 text-end" :pollution="weather?.airPollution"></air-quality>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-extended">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h3>Ветер</h3>
								<small class="text-muted">{{ weather?.wind?.name }}<span v-if="weather?.wind?.gust">. Порывами до {{ weather?.wind?.gust }} м/с</span></small>
                                <p>{{ weather?.wind?.speed }} м/с</p>
                            </div>
                            <div class="col-4">
                                <img class="img-fluid" style="width:7vw;" :src="'/img/icons/colored-line/wind-beaufort-' + (weather?.wind?.index || 0) + '.svg'">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-extended">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h3>{{ sunTitle }}</h3>
								<small class="text-muted">{{ sunDescription }}</small>
                                <p>{{ sunDate }}</p>
                            </div>
                            <div class="col-4">
                                <img class="img-fluid" style="width:7vw;" :src="sunIcon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-extended">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h3>Давление</h3>
								<small class="text-muted"> </small>
                                <p>{{ pressure }} мм.рт.ст.</p>
                            </div>
                            <div class="col-4">
                                <img class="img-fluid" style="width:7vw;" src="/img/icons/colored-line/barometer.svg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-extended">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h3>UV индекс</h3>
								<small class="text-muted">{{ weather?.sun?.uvIndex?.value }}</small>
                                <p>{{ weather?.sun?.uvIndex?.description }}</p>
                            </div>
                            <div class="col-4">
                                <img class="img-fluid" style="width:7vw;" :src="uvIndexIconUrl">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mt-2">
            <div class="col-1" v-for="index in 12" :key="index">
                <div>{{ getHourlyDate(index) }}</div>
                <img :src="getHourlyIconUrl(index)" alt="">
                <div class="text-center">{{ Math.round(hourly[index]?.temperature?.temp) }} °</div>
            </div>
        </div>
    </div>
</template>

<script>
    import Alert from './AlertsComponent.vue'
    import AirQuality from './AirQualityComponent.vue'
    import dayjs from 'dayjs';

	export default {
  		props: {
            weather: Object,
            hourly: Object,
            alerts: Object,
            place: Object,
            extend: Boolean,
        },
		data() {
			return {
                timestamp: undefined
            }
		},
        components: {
            AlertComponent: Alert,
            AirQuality
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
        },
        computed: {
            date() {
                if(!this.timestamp && this.weather.timestamp) {
                    this.timestamp = dayjs.unix(this.weather.timestamp);
                }

                if(this.timestamp) {
                    return this.timestamp.format('dddd, DD MMMM');
                }
            },
            time() {
                if(!this.timestamp && this.weather.timestamp) {
                    this.timestamp = dayjs.unix(this.weather.timestamp);
                }

                if(this.timestamp) {
                    return this.timestamp.format('HH:mm');
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
            pressure() {
                return Math.round(this.weather.pressure * 0.750062);
            },
            uvIndexIconUrl() {
                if(this.weather?.sun?.uvIndex?.index) {
                    return '/img/icons/colored-line/uv-index-' + this.weather.sun.uvIndex.index + '.svg';
                }

                return '/img/icons/colored-line/uv-index.svg';
            },
			sunTitle() {
				const now = dayjs().unix();

				if(this.weather?.sun && this.weather.sun.sunrise >= now) {
					return 'Восход';
				}

				return 'Закат';
				//return this.weather?.sun?.isNight ? 'Восход' : 'Закат';
			},
            sunDate() {
				const now = dayjs().unix();

                if(this.weather?.sun && this.weather.sun.sunrise >= now) {
                    return dayjs.unix(this.weather.sun.sunrise).fromNow();
                }

                if(this.weather?.sun?.sunset) {
				    return dayjs.unix(this.weather.sun.sunset).fromNow();
                }
            },
            sunDescription() {
				const now = dayjs().unix();

                if(this.weather?.sun && this.weather.sun.sunrise >= now) {
                    return dayjs.unix(this.weather.sun.sunrise).format('HH:mm');
                }

                if(this.weather?.sun?.sunset) {
                    return dayjs.unix(this.weather.sun.sunset).format('HH:mm');
                }
            },
			sunIcon() {
				const now = dayjs().unix();

				if(this.weather?.sun && this.weather.sun.sunrise >= now) {
					return '/img/icons/colored-line/sunrise.svg';
				}

				return '/img/icons/colored-line/sunset.svg';
			}
        }
	}
</script>

<style lang="scss" scoped>
	.today {
        .temperature {
            font-size: 20vw;
        }

        .icon {
            overflow: hidden;
            img {
                width: 50vh;

                &.extended {
                    width: 10vh;
                }
            }
        }

        &__extended {
            .temperature {
                font-size: 10vw;
                transform: translate(2vw, 0vw);
            }
            .temperature-text {
                text-align: center;
                transform: translate(0, -1vw);
            }
            .icon {
                overflow: hidden;
                img {
                    width: 20vw;

                    &.extended {
                        width: 10vw;
                    }
                }
            }

            .card-extended {
                background-color: rgba(144, 217, 251, 0.1);
            }
        }
    }

    .bg-day {
        background-color: #1c6cae!important;
    }
</style>
