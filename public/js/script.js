$(document).ready(function (){
    $('.container-calendar .calendar-header .btn-check-in').click(function (){
        let base_url = $('base').attr('href');
        let today = new Date();
        let date = today.getDate();
        let month = today.getMonth();
        let year = today.getFullYear();
        let hour = today.getHours();
        let minutes = today.getMinutes();
        let seconds = today.getSeconds();
        console.log(`${base_url}check-in\n${today}`);
        let now_element = $('.container-calendar .table-calendar#calendar').find($('#calendar-body td.selected'));

        $.ajax({
            type: 'POST',
            url: `${base_url}check-in`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                today: today,
                fulltime: `${year}-${month}-${date} ${hour}:${minutes}:${seconds}`,
            },
            success: function (response){
                if(response == 1){
                    console.log('Done!');
                    now_element.append(`<div class="working-times-in-out"><p class="checkin-time">${hour}:${minutes}</p></div>`);
                } else {
                    console.log('Lỗi gì đó');
                }
            },
            error: function (){
                console.log('Error');
            }
        });
    });
});
