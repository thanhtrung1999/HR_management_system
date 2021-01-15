<template>
    <div class="container-calendar">

        <div class="calendar-header position-relative row mb-3">
            <h3 id="monthAndYear"></h3>
            <div class="btn-in-out">
                <button class="btn btn-secondary" onclick="atNow()" @click="displayDataOnDom">Today</button>
                <button v-if="this.$store.state.WorkSchedule.isCheckinToday === false"
                        class="btn btn-secondary ml-2 btn-check-in" @click="checkIn">
                    Check in
                </button>
                <button v-if="this.$store.state.WorkSchedule.isCheckinToday === true && this.$store.state.WorkSchedule.isCheckoutToday === false"
                        class="float-right btn btn-warning ml-2 btn-check-out"
                        @click="checkOut">
                    Check out
                </button>
            </div>
        </div>

        <div class="button-container-calendar">
            <button id="previous" onclick="previous()" @click="displayDataOnDom">&#8249;</button>
            <button id="next" onclick="next()" @click="displayDataOnDom">&#8250;</button>
        </div>

        <table class="table-calendar" id="calendar" data-lang="en">
            <thead id="thead-month"></thead>
            <tbody id="calendar-body"></tbody>
        </table>

        <div class="footer-container-calendar">
            <label for="month">Jump To: </label>
            <select id="month" onchange="jump()" @change="displayDataOnDom">
                <option value=0>Jan</option>
                <option value=1>Feb</option>
                <option value=2>Mar</option>
                <option value=3>Apr</option>
                <option value=4>May</option>
                <option value=5>Jun</option>
                <option value=6>Jul</option>
                <option value=7>Aug</option>
                <option value=8>Sep</option>
                <option value=9>Oct</option>
                <option value=10>Nov</option>
                <option value=11>Dec</option>
            </select>
            <select id="year" onchange="jump()" @change="displayDataOnDom"></select>
        </div>

    </div>
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
    name: "WorkScheduleComponent",
    data() {
        return {

        }
    },
    created() {
        this.loadCalendar()
    },
    methods: {
        loadCalendar() {
            let uri = `${baseUrl}api/load-calendar`
            this.axios.post(uri,{
                employeeId: this.$attrs.employeeid
            },{
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                responseType: 'json'
            }).then(response => {
                console.log(response);
                this.$store.dispatch('updateWorkSchedule', response.data)
                this.displayDataOnDom();
            }).catch(error => {
                console.log(`Error: ${error}`)
            })
        },
        displayDataOnDom() {
            this.$store.commit('displayDataOnDom')
        },
        checkIn(e) {
            console.log(`${baseUrl}check-in\n${today}`)
            $(e.target).addClass('pending-checkin').text("Pending...")

            this.axios.post(`${baseUrl}api/check-in`, {
                employeeId: this.$attrs.employeeid,
                today: today,
                day: `${year}-${month}-${date}`,
                time: `${hour}:${minutes}:${seconds}`
            }, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            }).then(response => {
                console.log(response)
                if(parseInt(response.data) === 1){
                    this.loadCalendar()
                    this.displayDataOnDom()
                } else {
                    console.log('Lỗi gì đó... ' + response.data)
                    $(e.target).removeClass('pending-checkin').text('Check in')
                }
            }).catch(error => {
                console.log(`Error checkin: ${error}`)
            })
        },
        checkOut(e) {
            let r = confirm('Do you want to check-out now?')
            if (r === true) {
                console.log(`${baseUrl}check-out\n${today}`)
                $(e.target).addClass('pending-checkout').text("Pending...")

                this.axios.post(`${baseUrl}api/check-out`, {
                    employeeId: this.$attrs.employeeid,
                    today: today,
                    day: `${year}-${month}-${date}`,
                    time: `${hour}:${minutes}:${seconds}`
                }, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                }).then(response => {
                    if(parseInt(response.data) === 1){
                        this.loadCalendar()
                        this.displayDataOnDom()
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
