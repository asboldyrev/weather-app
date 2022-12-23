const messages = {
	en: {
		icons: (await import('../locales/en/icons.json')).default,
		interface: (await import('../locales/en/interface.json')).default,
		wind: (await import('../locales/en/wind.json')).default,
		airQuality: (await import('../locales/en/airQuality.json')).default,
	},
	ru: {
		icons: (await import('../locales/ru/icons.json')).default,
		interface: (await import('../locales/ru/interface.json')).default,
		wind: (await import('../locales/ru/wind.json')).default,
		airQuality: (await import('../locales/ru/airQuality.json')).default,
	}
}

export default {
	legacy: false,
	locale: 'ru',
	fallbackLocale: 'en',
	messages,
}
