<template>
    <div>
        AQI: {{ store.weather.current.airPollution?.aqi }}
        <div class="d-inline position-relative">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="heroicon_information-circle"
                :class="getAqiColor()"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
                @mouseover="showPopover = true"
                @mouseout="showPopover = false"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div
                class="popover bs-popover-auto show position-absolute"
                role="tooltip"
                data-popper-placement="right"
                v-show="showPopover"
            >
                <div class="popover-arrow" style="position: absolute; top: 0px; transform: translate(0px, 47px);"></div>
                <div class="popover-body">
                    <div>
                        <span class="block_indicator" :class="getColor('co')"></span>
                        <strong>CO</strong>: <span class="block text-muted">{{ store.weather.current.airPollution?.components?.co.value }} мкг/м<sup>3</sup></span>
                    </div>
                    <div>
                        <span class="block_indicator" :class="getColor('no2')"></span>
                        <strong>NO<sub>2</sub></strong>: <span class="block text-muted">{{ store.weather.current.airPollution?.components?.no2.value }} мкг/м<sup>3</sup></span>
                    </div>
                    <div>
                        <span class="block_indicator" :class="getColor('o3')"></span>
                        <strong>O<sub>3</sub></strong>: <span class="block text-muted">{{ store.weather.current.airPollution?.components?.o3.value }} мкг/м<sup>3</sup></span>
                    </div>
                    <div>
                        <span class="block_indicator" :class="getColor('so2')"></span>
                        <strong>SO<sub>2</sub></strong>: <span class="block text-muted">{{ store.weather.current.airPollution?.components?.so2.value }} мкг/м<sup>3</sup></span>
                    </div>
                    <div>
                        <span class="block_indicator" :class="getColor('pm2_5')"></span>
                        <strong>PM 2.5</strong>: <span class="block text-muted">{{ store.weather.current.airPollution?.components?.pm2_5.value }} мкг/м<sup>3</sup></span>
                    </div>
                    <div>
                        <span class="block_indicator" :class="getColor('pm10')"></span>
                        <strong>PM 10</strong>: <span class="block text-muted">{{ store.weather.current.airPollution?.components?.pm10.value }} мкг/м<sup>3</sup></span>
                    </div>
                </div>
            </div>
        </div>
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
                showPopover: false,
            }
        },
        methods: {
                getAqiColor() {
                    const classes = [
                        'very_low-aqi',
                        'low-aqi',
                        'medium-aqi',
                        'high-aqi',
                        'very_high-aqi',
                    ];

                    return classes[this.store.weather.current.airPollution?.aqi - 1];
                },
                getColor(name) {
                    const classes = [
                        'very_low',
                        'low',
                        'medium',
                        'high',
                        'very_high',
                    ];

                    return classes[this.store.weather.current.airPollution?.components[name]?.index - 1] || '';
                }
        }
    }
</script>

<style lang="scss" scoped>
    .block {
        &_indicator {
            margin-right: 10px;
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
    }

    .very_low {
        color: #fff;
        background:#31add3;

        &-aqi {
            color: #31add3;
        }
    }
    .low {
        background:#99b964;

        &-aqi {
            color: #99b964;
        }
    }
    .medium {
        background:#ffd236;

        &-aqi {
            color: #ffd236;
        }
    }
    .high {
        background:#ec783a;

        &-aqi {
            color: #d04730;
        }
    }
    .very_high {
        color: #fff;
        background:#d04730;

        &-aqi {
            color: #d04730;
        }
    }

    .heroicon_information-circle {
        width: 1.2rem;
        padding-bottom: 0.2rem;
    }

    .popover {
        left: 26px;
        transform: translate(0px, -45px);
        width: 268px;
    }
</style>
