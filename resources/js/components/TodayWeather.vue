<template>
    <div class="m-3">
        <div class="row g-3">
            <div class="col-md-12">
                <current-weather :weather="weather" :alerts="alerts" :place="place" :extend="extend"></current-weather>
            </div>
            <div class="col-md-6">
                <additional-information
                    title="Ветер"
                    :description="windDescription"
                    :content="weather.wind?.speed + ' м/с'"
                    :icon="'/img/icons/colored-line/wind-beaufort-' + (weather.wind?.index || 0) + '.svg'"
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
                    :description="weather?.sun?.uvIndex?.value.toString()"
                    :content="weather?.sun?.uvIndex?.description || ''"
                    :icon="uvIndexIconUrl"
                ></additional-information>
            </div>
        </div>
    </div>
</template>

<script>
    import CurrentWeather from './CurrentWeatherCompoment.vue'
    import AdditionalInformation from './CardAdditionalInfoComponent.vue'

    import dayjs from 'dayjs';

	export default {
        props: {
            weather: Object,
            alerts: Object,
            place: Object,
            extend: Boolean,
        },
        components: {
            CurrentWeather,
            AdditionalInformation
        },
        computed: {
            windDescription() {
                if(this.weather.wind?.gust) {
                    return this.weather.wind?.name + '. Порывами до ' + this.weather.wind?.gust + ' м/с'
                }

                return this.weather.wind?.name
            },
            sunTitle() {
				const now = dayjs().unix();

				if(this.weather?.sun && this.weather.sun.sunrise >= now) {
					return 'Восход';
				}

				return 'Закат';
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
        }
	}
</script>

<style lang="scss" scoped>
</style>
