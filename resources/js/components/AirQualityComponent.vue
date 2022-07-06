<template>
    <div>
        AQI: {{ pollution?.aqi }}
        <div class="d-inline position-relative">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="heroicon_information-circle"
                :class="getColor('aqi')"
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
                        <strong>CO</strong>: <span class="block text-muted">{{ pollution?.components?.co }} мкг/м<sup>3</sup></span>
                    </div>
                    <div>
                        <span class="block_indicator" :class="getColor('no2')"></span>
                        <strong>NO<sub>2</sub></strong>: <span class="block text-muted">{{ pollution?.components?.no2 }} мкг/м<sup>3</sup></span>
                    </div>
                    <div>
                        <span class="block_indicator" :class="getColor('o3')"></span>
                        <strong>O<sub>3</sub></strong>: <span class="block text-muted">{{ pollution?.components?.o3 }} мкг/м<sup>3</sup></span>
                    </div>
                    <div>
                        <span class="block_indicator" :class="getColor('so2')"></span>
                        <strong>SO<sub>2</sub></strong>: <span class="block text-muted">{{ pollution?.components?.so2 }} мкг/м<sup>3</sup></span>
                    </div>
                    <div>
                        <span class="block_indicator" :class="getColor('pm2_5')"></span>
                        <strong>PM 2.5</strong>: <span class="block text-muted">{{ pollution?.components?.pm2_5 }} мкг/м<sup>3</sup></span>
                    </div>
                    <div>
                        <span class="block_indicator" :class="getColor('pm10')"></span>
                        <strong>PM 10</strong>: <span class="block text-muted">{{ pollution?.components?.pm10 }} мкг/м<sup>3</sup></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        pollution: Object
    },
    data() {
        return {
            showPopover: false,
            colors: {
                co: [
                    [0, 5000], [5000, 7500], [7500, 10000], [10000, 20000], [20000]
                ],
                no2: [
                    [0,50], [50,100], [100,200], [200,400], [400]
                ],
                o3: [
                    [0,60], [60,120], [120,180], [180,240], [240]
                ],
                so2: [
                    [0,50], [50, 100], [100, 350], [350, 500], [500]
                ],
                pm2_5: [
                    [0,15], [15,30], [30,55], [55,110], [110]
                ],
                pm10: [
                    [0,25], [25,50], [50,90], [90,180], [180]
                ],
                aqi: [
                    [1,2], [2,3], [3,4], [4,5], [5,6]
                ],
            }
        }
    },
    methods: {

            getColor(name) {
                let value = this.pollution?.components[name];

                if(name == 'aqi') {
                    value = this.pollution?.aqi;

                    return {
                        'very_low-aqi': this.getBoolean(this.colors[name][0], value),
                        'low-aqi': this.getBoolean(this.colors[name][1], value),
                        'medium-aqi': this.getBoolean(this.colors[name][2], value),
                        'high-aqi': this.getBoolean(this.colors[name][3], value),
                        'very_high-aqi': this.getBoolean(this.colors[name][4], value),
                    };
                }

                return {
					'very_low': this.getBoolean(this.colors[name][0], value),
					'low': this.getBoolean(this.colors[name][1], value),
					'medium': this.getBoolean(this.colors[name][2], value),
					'high': this.getBoolean(this.colors[name][3], value),
					'very_high': this.getBoolean(this.colors[name][4], value),
				};
            },
            getBoolean(range, value) {
                if(range.length == 1) {
					return value > range[0];
				}

				if(range.length == 2) {
					return value >= range[0] && value < range[1];
				}

				return false;
            }
    }
}
</script>

<style lang="scss" scoped>
    .block {
        //background: #ccc;

        &_indicator {
            //margin-left: 10px;
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
