<template>
    <button class="btn btn-secondary ml-2 btn-check-in" @click="checkIn">Check in</button>
</template>

<script>
export default {
    name: "ButtonCheckin",
    methods: {
        checkIn() {
            this.$emit('checkIn')
        }
    }
}
</script>

<style scoped>

</style>
