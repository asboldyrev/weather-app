import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { useCityStore } from './city';

export const useSettingsStore = defineStore('settings', () => {
	const savedSettings = JSON.parse(localStorage.getItem('settings'));
	const city = useCityStore();

	let isLocalTimezone = ref(savedSettings?.isLocalTimezone);

	if (!savedSettings) {
		setTimezoneMode(true);
	}

	function setTimezoneMode(mode) {
		isLocalTimezone.value = mode;
		localStorage.setItem('settings', JSON.stringify({
			isLocalTimezone: isLocalTimezone.value,
		}));
	}

	const timezoneMode = computed(() => {
		return isLocalTimezone.value;
	});

	const timezone = computed(() => {
		if (!isLocalTimezone.value && city.getCityField('timezone')) {
			return city.getCityField('timezone');
		} else {
			return Intl.DateTimeFormat().resolvedOptions().timeZone;
		}
	});

	return {
		setTimezoneMode,
		timezoneMode,
		timezone,
	}
})
