import { computed, ref } from 'vue'
import { defineStore } from 'pinia'

export const useCityStore = defineStore('city', () => {
	const savedCity = localStorage.getItem('city');
	let _city = ref(JSON.parse(savedCity) || {});

	const city = computed(() => {
		return _city.value;

	});

	const setCity = (newСity) => {
		_city.value = newСity;
		localStorage.setItem('city', JSON.stringify(newСity));
	}

	const getCityField = (field) => {
		return _city.value[field] || undefined;
	}

	return {
		city,
		setCity,
		getCityField
	}
})
