import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import ruLocale from 'dayjs/locale/ru'

import './assets/main.scss'
import dayjs from 'dayjs'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')

dayjs.locale(ruLocale);

//window.addEventListener('load', async () => {
//	if ('serviceWorker' in navigator) {
//		try {
//			const reg = await navigator.serviceWorker.register('/src/service-worker.js', { type: 'module' })
//		} catch (e) {
//			console.log('Service worker register fail')
//		}
//	}
//})
