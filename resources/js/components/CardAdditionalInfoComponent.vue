<template>
    <div class="card card_additional">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <h3>{{ title }}</h3>
                    <small class="text-muted">{{ description || ' ' }}</small>
                    <p>{{ content }}</p>
                </div>
                <div class="col-4">
                    <img class="img-fluid" style="width:7vw;" :src="icon">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                required: true
            },
            description: {
                type: String
            },
            content: {
                type: String,
                required: true
            },
            icon: {
                type: String
            }
        }
    }
</script>

<style lang="scss" scoped>
    .card_additional {
        background-color: rgba(144, 217, 251, 0.1);
    }
</style>
