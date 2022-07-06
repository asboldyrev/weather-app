<template>
    <div id="swipe" class="w-100">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <today-weather :weather="weather.current" :hourly="weather.hourly" :alerts="weather.alerts" :place="place" extend></today-weather>
            </div>
            <div class="col-xs-12 d-sm-none d-block">
                Column 2
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <forecast-weather :forecast="weather.daily" :place="place" extend></forecast-weather>
            </div>
        </div>
    </div>
    <!--<div class="d-flex flex-column h-100">
        <div class="flex-grow-1">
            <div class="alert alert-danger position-absolute end-0 m-4 p-1" role="alert" v-if="!isOffline">Оффлайн режим</div>
            <div class="container h-100">
                <today-weather v-if="tab == 'today'" :weather="today" :city="city"></today-weather>
                <forecast-weather v-if="tab == 'forecast'" :forecast="forecast"></forecast-weather>
            </div>
        </div>
        <div class="p-2">
            <ul class="nav nav-fill">
                <li class="nav-item">
                    <a href="#" class="nav-link" :class="{'text-muted': tab == 'today'}" @click="tab='today'">Сегодня</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" :class="{'text-muted': tab == 'more'}" @click="tab='more'">Подробней</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" :class="{'text-muted': tab == 'forecast'}" @click="tab='forecast'">Прогноз</a>
                </li>
            </ul>
        </div>
    </div>-->
	<!--<desktop-placeholder v-if="!isMobile"></desktop-placeholder>
	<div v-else class="background-day">

        <div class="input-group p-3">
            <input class="form-control" list="datalistOptions" placeholder="Город" @input="autocomplite()" v-model="search" />
            <datalist id="datalistOptions">
                <option :value="address.value" v-for="(address, index) in addreses" :key="index" @click="selectAddress(index)"/>
            </datalist>
        </div>
        <ul class="nav nav-fill">
            <li class="nav-item">
                <a href="#" class="nav-link" :class="{'text-muted': tab == 'today'}" @click="tab='today'">Сегодня</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" :class="{'text-muted': tab == 'more'}" @click="tab='more'">Подробней</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" :class="{'text-muted': tab == 'forecast'}" @click="tab='forecast'">Прогноз</a>
            </li>
        </ul>

        <nav class="navbar fixed-bottom bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Fixed bottom</a>
            </div>
        </nav>
	</div>-->
</template>

<script>
import { weather } from './sdk'
import TodayWeather from './components/TodayWeather.vue'
import ForecastWeather from './components/ForecastWeather.vue'

import ruLocale from 'dayjs/locale/ru'
import relativeTime from 'dayjs/plugin/relativeTime'
import dayjs from 'dayjs'

export default {
  name: 'App',
  components: {
	TodayWeather: TodayWeather,
	ForecastWeather: ForecastWeather,
  },
  data() {
	return {
		tab: 'today',
        search: '',
		isMobile: false,
        isOffline: false,
        place: {
            lat: 51.193535,
            lon: 82.242081,
            locality: '',
            country: '',
            boundingBox: []
        },
        timezone: {
            timezone: '',
            timezoneOffset: 0
        },
        weather: {
            current: {},
            hourly: [],
            daily: [],
            alerts: []
        },
        addreses: []
	}
  },
  methods: {
    updateData() {
        weather({
            lat: this.place.lat,
            lon: this.place.lon,
            appid: this.token,
            exclude: 'minutely',
            lang: 'ru',
            units: 'metric'
        }).then(response => {
            this.weather = response.weather;
            this.place = response.place;
            this.timezone = response.timezone;

            this.isOffline = false;
        })
        .catch(error => {
            this.isOffline = true;
        });
    }
  },
  beforeMount() {
    dayjs.locale(ruLocale);
    dayjs.extend(relativeTime)

	let width = document.documentElement.clientWidth,
		height = document.documentElement.clientHeight
	this.isMobile = width < 1000 && width < height;

	this.updateData();
  }
}
</script>

<style lang="scss">
    datalist {
        appearance: none
    }
</style>
