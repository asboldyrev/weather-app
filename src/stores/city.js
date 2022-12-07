import { ref } from 'vue'
import { defineStore } from 'pinia'

export const useCityStore = defineStore('city', () => {
	const savedCity = localStorage.getItem('city');
	let city = ref(JSON.parse(savedCity) || {});

	const getCity = () => {
		return city.value;
	}

	const setCity = (newСity) => {
		city.value = newСity;
		localStorage.setItem('city', JSON.stringify(newСity));
	}

	const getCityField = (field) => {
		return city.value[field] || undefined;
	}

	return {
		city, getCity, setCity, getCityField
	}
})
