<template>
    <button class="float-right btn btn-warning ml-2 btn-check-out" @click="checkOut">Check out</button>
</template>

<script>
const baseUrl = $('base').attr('href')
const today = new Date()
const date = today.getDate()
const month = today.getMonth()+1
const year = today.getFullYear()
const hour = today.getHours()
const minutes = today.getMinutes()
const seconds = today.getSeconds()

export default {
    name: "ButtonCheckout",
    methods: {
        checkOut(e) {
            let r = confirm('Do you want to check-out now?')
            if (r === true) {
                console.log(`${baseUrl}check-out\n${today}`)
                $(e.target).addClass('pending-checkout').text("Pending...")

                this.axios.post(`${baseUrl}api/check-out`, {
                    employeeId: this.$parent.$attrs.employeeid,
                    today: today,
                    day: `${year}-${month}-${date}`,
                    time: `${hour}:${minutes}:${seconds}`
                }, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                }).then(response => {
                    if(parseInt(response.data) === 1){
                        this.$parent.loadCalendar()
                        this.$parent.displayDataOnDom()
                    } else {
                        console.log('Lỗi gì đó... ' + response.data)
                        $(e.target).removeClass('pending-checkout').text('Check out')
                    }
                }).catch(error => {
                    console.log(`Error checkout: ${error}`)
                })
            }
        }
    }
}
</script>

<style scoped>

</style>
