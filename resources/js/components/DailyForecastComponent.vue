<template>
    <div class="card mb-3">
        <div class="card-header position-relative" @click="opened = !opened">
            <div class="h3 mt-2">{{ temperature }} °C</div>
            <div class="h6">{{ date }}</div>
            <img class="position-absolute end-0" :src="iconUrl">
        </div>
        <div class="card-body" v-show="opened">
            <table class="table table-borderless table-sm align-middle">
                <tr>
                    <td style="width:1px;">
                        <img src="/img/icons/colored-line/barometer.svg">
                    </td>
                    <td>{{ pressure }} мм.р.с.</td>

                    <td style="width:1px;">
                        <img src="/img/icons/colored-line/windsock.svg">
                    </td>
                    <td>{{ forecast.wind.speed }} м/с</td>
                </tr>
                <tr>
                    <td>
                        <img src="/img/icons/colored-line/humidity.svg">
                    </td>
                    <td>{{ forecast.humidity }} %</td>

                    <td style="width:1px;">
                        <img src="/img/icons/colored-line/compass.svg">
                    </td>
                    <td>{{ forecast.wind.direction }}</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    import dayjs from 'dayjs'

    export default {
        props: {
            forecast: Object
        },
        data() {
            return {
                opened: false
            }
        },
        computed: {
            temperature() {
                const max = this.forecast.temperature.temp.max;
                const min = this.forecast.temperature.temp.min;

                return Math.round((max + min) / 2);
            },
            date() {
                return dayjs.unix(this.forecast.timestamp).format('dddd, DD MMMM');
            },
            iconUrl() {
                let filename = 'not-available';

                if(this.forecast?.icon?.day) {
                    filename = this.forecast?.icon?.day;
                }

                return '/img/icons/colored-fill/' + filename + '.svg';
            },
            pressure() {
                return Math.round(this.forecast.pressure * 0.750062);
            },
        }
    }
</script>

<style lang="scss" scoped>
    .card-header {
        cursor: pointer;

		img {
			top: -4px;
			width: 100px;
		}
	}
	.card-body {
		img {
			width: 50px;
			height: 50px;
		}
	}
</style>
