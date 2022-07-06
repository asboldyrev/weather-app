<template>
	<div class="mt-4">
		<div class="card mb-3" v-for="(day, index) in forecast" :key="index">
			<div class="card-header position-relative" @click="toggleDay(index)">
				<div class="h3 mt-2">{{ getTemperature(day) }} °C</div>
				<div class="h6">{{ getDate(day) }}</div>
				<img class="position-absolute end-0" :src="getIconUrl(day)">
			</div>
			<div class="card-body" v-show="openedDays.indexOf(index) != -1">
				<table class="table table-borderless table-sm align-middle">
					<tr>
						<td style="width:1px;">
							<img src="/img/icons/colored-line/barometer.svg">
						</td>
						<td>{{ getPressure(day) }} мм.рт.ст.</td>

						<td style="width:1px;">
							<img src="/img/icons/colored-line/windsock.svg">
						</td>
						<td>{{ day.wind.speed }} м/с</td>
					</tr>
					<tr>
						<td>
							<img src="/img/icons/colored-line/humidity.svg">
						</td>
						<td>{{ day.humidity }} %</td>

						<td style="width:1px;">
							<img src="/img/icons/colored-line/compass.svg">
						</td>
						<td>{{ day.wind.direction }}</td>
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
            openedDays: []
        }
	},
	methods: {
        toggleDay(index) {
            const positionIndex = this.openedDays.indexOf(index);

            if(positionIndex == -1) {
                this.openedDays.push(index);
            } else {
                this.openedDays.splice(positionIndex, 1);
            }
        },
        getTemperature(day) {
            const max = day.temperature.temp.max;
            const min = day.temperature.temp.min;

            return Math.round((max + min) / 2);
        },
        getDate(day) {
            return dayjs.unix(day.timestamp).format('dddd, DD MMMM');
        },
        getPressure(day) {
            return Math.round(day.pressure * 0.750062);
        },
		getIconUrl(day) {
			let filename = 'not-available';

			if(day?.icon?.day) {
				filename = day?.icon?.day;
			}

			return '/img/icons/colored-fill/' + filename + '.svg';
		}
	},
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
