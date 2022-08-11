<template>
    <div class="card bg-day text-white current">
        <div class="card-body position-relative">
            <div class="alert_offline position-absolute m-2" v-show="store.isOffline">
                Нет соединеня с сервером
                <svg xmlns="http://www.w3.org/2000/svg" class="alert_offline_icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke="#ffffff" fill="#eb1a1a" stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="row h-100">
                <div class="col-6 h-100">
                    <div class="row">
                        <div class="col-6">
                            <h4>{{ store.place.locality }}</h4>
                            <p>{{ store.place.country }}</p>
                        </div>
                        <div class="col-6 text-end">
                            <h4>{{ time }}</h4>
                            <p>{{ date }}</p>
                        </div>
                    </div>
                    <div class="row h-100">
                        <div class="col-12 position-relative">
                            <h1 class="temperature">{{ temperature }}°</h1>
                            <p class="temperature_description">{{ store.weather.current.description }}</p>
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
                    <alerts></alerts>
                </div>
                <div class="col-6">
                    <air-quality class="mt-3 text-end"></air-quality>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Alerts from './AlertsComponent.vue'
    import AirQuality from './AirQualityComponent.vue'

    import { useStore } from '../store';

    export default {
        setup() {
            const store = useStore()

            return { store }
        },
        components: {
            Alerts,
            AirQuality
        },
        computed: {
            date() {
                const timestamp = this.store.weather?.current.timestamp;

                if(timestamp) {
                    return this.$dayjs.unix(timestamp).format('dd, DD MMMM');
                }
            },
            time() {
                const timestamp = this.store.weather?.current.timestamp;

                if(timestamp) {
                    return this.$dayjs.unix(timestamp).format('HH:mm');
                }
            },
            temperature() {
                const temperature = this.store.weather?.current?.temperature?.temp;

                if(temperature) {
                    return Math.round(temperature);
                }
            },
            iconUrl() {
				let filename = 'not-available';

				if(this.store.weather.current.sun && this.store.weather.current.sun.isNight) {
                    filename = this.store.weather.current.icon.night;
				} else if(this.store.weather.current.sun) {
                    filename = this.store.weather.current.icon.day;
                }

				return '/img/icons/colored-fill/' + filename + '.svg';
			},
        }
    }
</script>

<style lang="scss" scoped>
    .current {
        background-color: #1c6cae!important;

        .alert_offline {
            top: 0;
            right: 0;

            &_icon {
                width: 25px;
            }
        }

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
