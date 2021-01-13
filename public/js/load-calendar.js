// loadCalendar();

/*function loadCalendar(){
    const base_url = $('base').attr('href');

    $.ajax({
        url: `${base_url}load-calendar`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        success: data => {
            console.log('The returned data is being processed');
            for (let sub_data of data){
                let checkinTime = new Date(sub_data.working_on_day + ' ' + sub_data.checkin_time);
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
                    if (sub_data.checkin_time !== null){
                        $('.calendar-header .btn-in-out .btn-check-in').replaceWith('<button class="float-right btn btn-warning ml-2 btn-check-out">Check out</button>');
                    }
                    if (sub_data.checkout_time !== null){
                        $('.calendar-header .btn-in-out .btn-check-out').remove();
                    }
                }

                if (sub_data.checkout_time !== null){
                    checkoutTime = new Date(sub_data.working_on_day + ' ' + sub_data.checkout_time);
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
            console.log('Completed');
        },
        error: function (){
            console.log('Error load data');
        }
    });
}*/
