import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import dayjs from '../use/dayjs';

export const useCityStore = defineStore('city', () => {
	const savedCity = localStorage.getItem('city');
	let _city = ref(JSON.parse(savedCity) || {});

	const setCity = (newСity) => {
		_city.value = newСity;
		localStorage.setItem('city', JSON.stringify(newСity));
	}

	const getCityField = (field) => {
		return _city.value[field] || undefined;
	}

	const city = computed(() => {
		return _city.value;

	});

	const timezone = computed(() => {
		return _city.value?.timezone;
	});

	const currentHour = computed(() => {
		return currentDate.value.hour();
	});

	const currentDate = computed(() => {
		return dayjs().tz(timezone.value);
	});

	return {
		setCity,
		getCityField,
		city,
		timezone,
		currentHour,
		currentDate
	}
})
