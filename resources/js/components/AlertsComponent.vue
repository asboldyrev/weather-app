<template>
    <div v-if="store.weather.alerts.length">
        <div class="modal modal-alerts" :class="{ 'd-block': openedModal }" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Предупреждения</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="openedModal = false"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-4">
                            <div v-for="(alert, index) in store.weather.alerts" :key="index">
                                <h4 class="mt-4 mb-0">{{ alert.event }}</h4>
                                <small class="text-muted">{{ getAlertDate(alert.start) }} — {{ getAlertDate(alert.end) }}</small>
                                <p class="mt-2" v-if="alert.description">{{ alert.description }}</p>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-warning position-relative" @click="openedModal = !openedModal">
            <svg xmlns="http://www.w3.org/2000/svg" class="heroicon_exclamation-circle" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ store.weather.alerts[0].event }}<span v-if="store.weather.alerts.length > 1"> +{{ store.weather.alerts.length - 1 }}</span>
        </button>
    </div>
</template>

<script>
    import { useStore } from '../store'

    export default {
        setup() {
            const store = useStore()

            return { store }
        },
        data() {
            return {
                openedModal: false
            }
        },
        methods: {
            getAlertDate(timestamp) {
                if(timestamp) {
                    return this.$dayjs.unix(timestamp).format('DD.MM HH:mm')
                }
            },
        }
    }
</script>

<style lang="scss" scoped>
    .modal-alerts {
        color: var(--bs-body-color);
    }

    .heroicon_exclamation-circle {
        width: 1.2rem;
        padding-bottom: 0.2rem;
    }
</style>
