import { defineStore } from 'pinia'
import { weather } from './sdk'

export const useStore = defineStore('main', {
    state: () => ({
        isOffline: true,
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
        }
    }),
    actions: {
        updateData() {
            weather({
                lat: this.place.lat,
                lon: this.place.lon,
                exclude: 'minutely',
                lang: 'ru',
                units: 'metric'
            }).then(response => {
                this.weather.current = response.weather.current;
                this.weather.hourly = response.weather.hourly;
                this.weather.daily = response.weather.daily;
                this.weather.alerts = response.weather.alerts;
                this.place = response.place;
                this.timezone = response.timezone;

                this.isOffline = false;
            })
            .catch(error => {
                console.log(error);
                this.isOffline = true;
            });
        }
    }
});
