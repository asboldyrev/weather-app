import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import { createI18n } from 'vue-i18n'
import usei18nConfig from './use/i18nConfig'

import './assets/main.scss'

const version = 'v0.1';

const i18n = createI18n(usei18nConfig)
const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(i18n)

app.mount('#app')

if (localStorage.getItem('version') != version) {
	localStorage.clear();
	localStorage.setItem('version', version);
}

//window.addEventListener('load', async () => {
//	if ('serviceWorker' in navigator) {
//		try {
//			const reg = await navigator.serviceWorker.register('/src/service-worker.js', { type: 'module' })
//		} catch (e) {
//			console.log('Service worker register fail')
//		}
//	}
//})

Number.prototype.round = function (decimals) {
	return Number((Math.round(this + "e" + decimals) + "e-" + decimals));
}
