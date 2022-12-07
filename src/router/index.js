import { createRouter, createWebHashHistory } from 'vue-router'
import Current from '../views/Current.vue'
import Forecast from '../views/Forecast.vue'
import Settings from '../views/Settings.vue'
import Details from '../views/Details.vue'

const router = createRouter({
	history: createWebHashHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'current',
			component: Current
		},
		{
			path: '/details',
			name: 'details',
			component: Details
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
