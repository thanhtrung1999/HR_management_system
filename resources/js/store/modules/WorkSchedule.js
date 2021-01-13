const state = {
    data: []
}
const getters = {

}
const mutations = {
    updateWorkSchedule(state, payload) {
        state.data = payload
    },
    displayDataOnDom(state) {
        for (let subData of state.data) {
            let checkinTime = new Date(subData.working_on_day + ' ' + subData.checkin_time);
            let date = checkinTime.getDate();
            let month = checkinTime.getMonth()+1;
            let year = checkinTime.getFullYear();
            let checkinHour = checkinTime.getHours();
            let checkinMinutes = checkinTime.getMinutes();
            if ((checkinMinutes.toString()).length === 1){
                checkinMinutes = `0${checkinMinutes}`;
            }

            let checkoutTime;
            let checkoutHour;
            let checkoutMinutes;

            let tdElementDay = $(`.table-calendar#calendar td[data-date="${date}"][data-month="${month}"][data-year="${year}"]`);
            let today = new Date();
            if(isCheckInToday(today.getDate(), today.getMonth()+1, today.getFullYear(), date, month, year)){
                if (subData.checkin_time !== null){
                    $('.calendar-header .btn-in-out .btn-check-in').replaceWith('<button class="float-right btn btn-warning ml-2 btn-check-out">Check out</button>');
                }
                if (subData.checkout_time !== null){
                    $('.calendar-header .btn-in-out .btn-check-out').remove();
                }
            }

            if (subData.checkout_time !== null){
                checkoutTime = new Date(subData.working_on_day + ' ' + subData.checkout_time);
                checkoutHour = checkoutTime.getHours();
                checkoutMinutes = checkoutTime.getMinutes();
                if ((checkoutMinutes.toString()).length === 1){
                    checkoutMinutes = `0${checkoutMinutes}`;
                }
                tdElementDay.html(
                    `<span>${date}</span>
                    <div class="working-times-in-out">
                        <p class="checkin-time">${checkinHour}:${checkinMinutes}</p>
                        <p class="checkout-time">${checkoutHour}:${checkoutMinutes}</p>
                    </div>`
                );
            } else {
                tdElementDay.html(
                    `<span>${date}</span>
                    <div class="working-times-in-out">
                        <p class="checkin-time">${checkinHour}:${checkinMinutes}</p>
                    </div>`
                );
            }

            if ((checkinHour > 9 || (checkinHour === 9 && checkinMinutes > 0))){
                tdElementDay.find($('.working-times-in-out p.checkin-time')).css({
                    'background-color': '#ef5959',
                    'color': '#f1f1f1',
                });
            }
            if (checkoutHour < 17 || (checkoutHour === 17 && checkoutMinutes < 30)){
                tdElementDay.find($('.working-times-in-out p.checkout-time')).css({
                    'background-color': '#ef5959',
                    'color': '#f1f1f1',
                });
            }
        }
    }
}
const actions = {
    updateWorkSchedule({ commit }, payload) {
        commit('updateWorkSchedule', payload)
    }
}

const isCheckInToday = (date, month, year, checkinDate, checkinMonth, checkinYear) => {
    return date === checkinDate && month === checkinMonth && year === checkinYear;
}

export default {
    state,
    getters,
    mutations,
    actions
}
