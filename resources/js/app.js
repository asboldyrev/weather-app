import { createApp } from 'vue'
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

createApp(App).mount('#app')
