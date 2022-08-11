import { createApp } from 'vue'
import { createPinia } from 'pinia'
import dayjs from 'dayjs'
import App from './App.vue'

import 'bootstrap/dist/css/bootstrap.min.css';

window.addEventListener('load', async () => {
    if ('serviceWorker' in navigator) {
        try {
            const reg = await navigator.serviceWorker.register('/service-worker.js')
            console.log('Service worker register success')
        } catch (e) {
            console.log('Service worker register fail')
        }
    }
})

const pinia = createPinia();

const app = createApp(App);
app.config.globalProperties.$dayjs = dayjs
app.use(pinia)
app.mount('#app')
