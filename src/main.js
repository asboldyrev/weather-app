import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import './assets/main.scss'

const version = 'v0.1';

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')

if(localStorage.getItem('version') != version) {
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

Number.prototype.round = function(decimals) {
	return Number((Math.round(this + "e" + decimals) + "e-" + decimals));
}
