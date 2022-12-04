import { createRouter, createWebHistory } from 'vue-router'
import Current from '../views/Current.vue'
import Forecast from '../views/Forecast.vue'
import Settings from '../views/Settings.vue'

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'current',
			component: Current
		},
		{
			path: '/forecast',
			name: 'forecast',
			component: Forecast
		},
		{
			path: '/settings',
			name: 'settings',
			component: Settings
		},
	]
})

export default router
