<template>
    <div class="card mb-3">
        <div class="card-header position-relative" @click="opened = !opened">
            <div class="clearfix">
                <div class="float-start" style="height: 39px; margin-top: 4px; margin-bottom: -4px;">{{ date }}</div>
                <div class="float-end">{{ temperature('max') }} / {{ temperature('min') }} °C <img class="d-inline" :src="iconUrl"></div>
            </div>
        </div>
        <div v-show="opened">
            <div class="table-responsive">
                <table class="table-responsive w-100">
                    <tr>
                        <td class="p-2 ps-4">Осадки</td>
                        <td class="text-end p-2 pe-4">{{ forecast.rain }} мм<span v-if="forecast.pop"> ({{ forecast.pop }} %)</span></td>
                    </tr>
                    <tr>
                        <td class="p-2 ps-4">Ветер</td>
                        <td class="text-end p-2 pe-4">{{ forecast.wind.speed }} м/с {{ forecast.wind.direction }}</td>
                    </tr>
                    <tr>
                        <td class="p-2 ps-4">Давление</td>
                        <td class="text-end p-2 pe-4">{{ pressure }} мм.р.с.</td>
                    </tr>
                    <tr>
                        <td class="p-2 ps-4">Влажность</td>
                        <td class="text-end p-2 pe-4">{{ forecast.humidity }} %</td>
                    </tr>
                    <tr>
                        <td class="p-2 ps-4">UV индекс</td>
                        <td class="text-end p-2 pe-4">{{ forecast.sun.uvIndex.value.toFixed(1) }}</td>
                    </tr>
                    <tr>
                        <td class="p-2 ps-4">Восход</td>
                        <td class="text-end p-2 pe-4">{{ sunTime(forecast.sun.sunrise) }}</td>
                    </tr>
                    <tr>
                        <td class="p-2 ps-4">Закат</td>
                        <td class="text-end p-2 pe-4">{{ sunTime(forecast.sun.sunset) }}</td>
                    </tr>
                </table>
            </div>
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
        methods: {
            temperature(field) {
                return Math.round(this.forecast.temperature.temp[field]);
            },
            sunTime(timestamp) {
                return dayjs.unix(timestamp).format('HH:mm');
            }
        },
        computed: {
            date() {
                return dayjs.unix(this.forecast.timestamp).format('dd, DD MMMM');
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
			width: 50px;
            margin-top: -7px;
            margin-bottom: -4px;
		}
	}
	.card-body {
		img {
			width: 50px;
			height: 50px;
		}
	}
    tr {
        border-bottom: 1px solid #dee2e6 !important;
    }
    td {

    }
</style>
