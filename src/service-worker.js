/* eslint-disable no-console */

if (process.env.NODE_ENV === 'production') {
	const staticCacheName = 'v1.0.0-s'
	const dynamicCacheName = 'v1.0.0-d'

	const assetUrls = [
		'/',
		'/js/app.js',
		'/favicons/icon-512x512.png',
		'/favicons/icon-384x384.png',
		'/favicons/icon-256x256.png',
		'/favicons/icon-192x192.png',
		'/icons/colored-fill/not-available.svg',
		'/icons/colored-line/barometer.svg',
		'/icons/colored-line/windsock.svg',
		'/icons/colored-line/humidity.svg',
		'/icons/colored-line/compass.svg',
	];

	self.addEventListener('install', async event => {
		const cache = await caches.open(staticCacheName)
		await cache.addAll(assetUrls)
	})

	self.addEventListener('activate', async event => {
		const cacheNames = await caches.keys()
		await Promise.all(
			cacheNames
				.filter(name => name !== staticCacheName)
				.filter(name => name !== dynamicCacheName)
				.map(name => caches.delete(name))
		)
	})

	self.addEventListener('fetch', async event => {
		const { request } = event

		const url = new URL(request.url)

		if (
			assetUrls.indexOf(url.pathname) != -1 &&
			url.pathname.indexOf('api') == -1 &&
			url.pathname.indexOf('browser-sync') == -1
		) {
			event.respondWith(cacheFirst(request))
		} else if (
			url.pathname.indexOf('api') == -1 &&
			url.pathname.indexOf('browser-sync') == -1
		) {
			event.respondWith(networkFirst(request))
		} else if (
			url.pathname.indexOf('api') != -1
		) {
			try {
				const response = await fetch(request)
				return response ?? await caches.match('/offline')
			} catch (e) {
				//
			}
		}
	})

	async function cacheFirst(request) {
		const cached = await caches.match(request)
		return cached ?? await fetch(request)
	}

	async function networkFirst(request) {
		const cache = await caches.open(dynamicCacheName)
		try {
			const response = await fetch(request)
			await cache.put(request, response.clone())
			return response
		} catch (e) {
			const cached = await cache.match(request)
			return cached ?? await caches.match('/offline')
		}
	}
}
