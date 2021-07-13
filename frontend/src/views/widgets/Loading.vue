<template>
    <div>
        <div class="animated fadeIn" v-if="visibility">
            <b-row align-v="center" class="loader">
                <b-col>
                    <b-spinner></b-spinner>
                    <br><br>
                    <strong>{{label}}</strong>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Loading",
        props: {
            label: {
                type: String,
                default: 'Loading...'
            },
            visibility: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style scoped>

</style>