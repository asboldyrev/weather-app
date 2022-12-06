import { ref } from 'vue'
import { defineStore } from 'pinia'

const firstSettings = {
	localTimezone: true
};

if (!localStorage.getItem('settings')) {
	localStorage.setItem('settings', JSON.stringify(firstSettings));
}

export const useSettingsStore = defineStore('settings', () => {
	const savedSettings = localStorage.getItem('settings');
	let settings = ref(JSON.parse(savedSettings));

	const setSetting = (property, newValue) => {
		settings.value[property] = newValue;
		saveSetting();
	}

	const getSetting = (property) => {
		return settings.value[property];
	}


	const saveSetting = () => {
		localStorage.setItem('settings', JSON.stringify(settings.value));
	}

	return {
		settings,
		setSetting,
		getSetting
	}
})
