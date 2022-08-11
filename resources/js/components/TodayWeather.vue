<template>
    <div class="m-3">
        <div class="row g-3">
            <div class="col-md-12">
                <current-weather></current-weather>
            </div>
            <div class="col-md-6">
                <additional-information
                    title="Ветер"
                    :description="windDescription"
                    :content="store.weather?.current.wind?.speed + ' м/с'"
                    :icon="'/img/icons/colored-line/wind-beaufort-' + (store.weather?.current.wind?.index || 0) + '.svg'"
                ></additional-information>
            </div>
            <div class="col-md-6">
                <additional-information
                    :title="sunTitle"
                    :description="sunDescription"
                    :content="sunDate || ''"
                    :icon="sunIcon"
                ></additional-information>
            </div>
            <div class="col-md-6">
                <additional-information
                    title="Давление"
                    :content="pressure + ' мм.р.с.'"
                    icon="/img/icons/colored-line/barometer.svg"
                ></additional-information>
            </div>
            <div class="col-md-6">
                <additional-information
                    title="UV индекс"
                    :description="store.weather.current?.sun?.uvIndex?.value.toString()"
                    :content="store.weather.current?.sun?.uvIndex?.description || ''"
                    :icon="uvIndexIconUrl"
                ></additional-information>
            </div>
        </div>
    </div>
</template>

<script>
    import CurrentWeather from './CurrentWeatherCompoment.vue'
    import AdditionalInformation from './CardAdditionalInfoComponent.vue'

    import { useStore } from '../store'

	export default {
        setup() {
            const store = useStore()

            return { store }
        },
        components: {
            CurrentWeather,
            AdditionalInformation
        },
        computed: {
            windDescription() {
                if(this.store.weather.current.wind?.gust) {
                    return this.store.weather.current.wind?.name + '. Порывами до ' + this.store.weather.current.wind?.gust + ' м/с'
                }

                return this.store.weather.current.wind?.name
            },
            sunTitle() {
				const now = this.$dayjs().unix();

				if(this.store.weather.current?.sun && this.store.weather.current.sun.sunrise >= now) {
					return 'Восход';
				}

				return 'Закат';
			},
            sunDate() {
				const now = this.$dayjs().unix();

                if(this.store.weather.current?.sun && this.store.weather.current.sun.sunrise >= now) {
                    return this.$dayjs.unix(this.store.weather.current.sun.sunrise).fromNow();
                }

                if(this.store.weather.current?.sun?.sunset) {
				    return this.$dayjs.unix(this.store.weather.current.sun.sunset).fromNow();
                }
            },
            sunDescription() {
				const now = this.$dayjs().unix();

                if(this.store.weather.current?.sun && this.store.weather.current.sun.sunrise >= now) {
                    return this.$dayjs.unix(this.store.weather.current.sun.sunrise).format('HH:mm');
                }

                if(this.store.weather.current?.sun?.sunset) {
                    return this.$dayjs.unix(this.store.weather.current.sun.sunset).format('HH:mm');
                }
            },
            sunIcon() {
				const now = this.$dayjs().unix();

				if(this.store.weather.current?.sun && this.store.weather.current.sun.sunrise >= now) {
					return '/img/icons/colored-line/sunrise.svg';
				}

				return '/img/icons/colored-line/sunset.svg';
			},
            pressure() {
                return Math.round(this.store.weather.current.pressure * 0.750062);
            },
            uvIndexIconUrl() {
                if(this.store.weather.current?.sun?.uvIndex?.index) {
                    return '/img/icons/colored-line/uv-index-' + this.store.weather.current.sun.uvIndex.index + '.svg';
                }

                return '/img/icons/colored-line/uv-index.svg';
            },
        }
	}
</script>

<style lang="scss" scoped>
</style>
