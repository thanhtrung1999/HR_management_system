<template>
    <div class="container-calendar">

        <div class="calendar-header position-relative row mb-3">
            <h3 id="monthAndYear"></h3>
            <div class="btn-in-out">
                <button class="btn btn-secondary" onclick="atNow()" @click="displayDataOnDom">Today</button>
                <button v-if="!isCheckinToday"
                        class="btn btn-secondary ml-2 btn-check-in"
                        @click="checkIn">
                    Check in
                </button>
                <button v-else-if="isCheckinToday && !isCheckoutToday"
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
import { mapState } from 'vuex'
import { axiosModule } from '../../modules/axios'
import env from '../../routes/env'

const today = new Date()
const date = today.getDate()
const month = today.getMonth()+1
const year = today.getFullYear()
const hour = today.getHours()
const minutes = today.getMinutes()
const seconds = today.getSeconds()

axiosModule.config = {
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
}

export default {
    name: "WorkScheduleComponent",
    data() {
        return {

        }
    },
    created() {
        this.loadCalendar()
    },
    computed: {
        ...mapState({
            isCheckinToday: state => state.WorkSchedule.isCheckinToday,
            isCheckoutToday: state => state.WorkSchedule.isCheckoutToday
        })
    },
    methods: {
        loadCalendar() {
            $('body div.wrapper').before('<div class="loader loader-default is-active"></div>');

            axiosModule.baseUrl = env.routes.api.loadCalendar
            axiosModule.data = {
                employeeId: this.$attrs.employeeid
            }

            axiosModule.methods.post(() => {
                $('div.loader').remove()
                const response = axiosModule.response
                this.$store.dispatch('updateWorkSchedule', response.data)
                this.displayDataOnDom();
            }, () => {
                $('div.loader').remove()
                const error = axiosModule.error
                console.log(`Error: ${error}`)
            })

            console.log(axiosModule)
        },
        displayDataOnDom() {
            this.$store.commit('displayDataOnDom')
        },
        checkIn(e) {
            console.log(env.routes.api.checkIn)
            $(e.target).addClass('pending-checkin').text("Pending...")

            axiosModule.baseUrl = env.routes.api.checkIn
            axiosModule.data = {
                employeeId: this.$attrs.employeeid,
                today: today,
                day: `${year}-${month}-${date}`,
                time: `${hour}:${minutes}:${seconds}`
            }
            axiosModule.methods.post(() => {
                const response = axiosModule.response
                if(parseInt(response.data) === 1){
                    this.loadCalendar()
                    this.displayDataOnDom()
                    $(e.target).removeClass('pending-checkin').text('Check out')
                } else {
                    alert(response.data)
                    $(e.target).removeClass('pending-checkin').text('Check in')
                }
            }, () => {
                const error = axiosModule.error
                console.log(`Error checkin: ${error}`)
            })
        },
        checkOut(e) {
            let r = confirm('Do you want to check-out now?')
            if (r === true) {
                console.log(env.routes.api.checkOut)
                $(e.target).addClass('pending-checkout').text("Pending...")

                axiosModule.baseUrl = env.routes.api.checkOut
                axiosModule.data = {
                    employeeId: this.$attrs.employeeid,
                    today: today,
                    day: `${year}-${month}-${date}`,
                    time: `${hour}:${minutes}:${seconds}`
                }
                axiosModule.methods.post(() => {
                    const response = axiosModule.response
                    if(parseInt(response.data) === 1){
                        this.loadCalendar()
                        this.displayDataOnDom()
                        $(e.target).removeClass('pending-checkout').text('')
                    } else {
                        alert(response.data)
                        $(e.target).removeClass('pending-checkout').text('Check out')
                    }
                }, () => {
                    const error = axiosModule.error
                    console.log(`Error checkout: ${error}`)
                })
            }
        }
    }
}
</script>

<style scoped>

</style>
