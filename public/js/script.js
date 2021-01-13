$(document).ready(function (){
    const base_url = $('base').attr('href');
    const today = new Date();
    const date = today.getDate();
    const month = today.getMonth()+1;
    const year = today.getFullYear();
    const hour = today.getHours();
    const minutes = today.getMinutes();
    const seconds = today.getSeconds();

    $('.container-calendar .calendar-header .btn-check-in').click(function (){
        console.log(`${base_url}check-in\n${today}`);
        $(this).addClass('pending-checkin').text("Pending...");

        $.ajax({
            type: 'POST',
            url: `${base_url}check-in`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                today: today,
                day: `${year}-${month}-${date}`,
                time: `${hour}:${minutes}:${seconds}`,
            },
            success: response => {
                if(parseInt(response) === 1){
                    console.log('Done!');
                    //loadCalendar();
                } else {
                    console.log('Lỗi gì đó... ' + response);
                    $(this).removeClass('pending-checkin').text('Check in');
                }
            },
            error: function (){
                console.log('Error');
            }
        });
    });

    $(document).on('click', '.btn-check-out', function () {
        let r = confirm('Do you want to check-out now?');
        if (r === true) {
            console.log(`${base_url}check-out\n${today}`);
            $(this).addClass('pending-checkout').text("Pending...");

            $.ajax({
                type: 'POST',
                url: `${base_url}check-out`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    today: today,
                    day: `${year}-${month}-${date}`,
                    time: `${hour}:${minutes}:${seconds}`,
                },
                success: response => {
                    if(parseInt(response) === 1){
                        console.log('Done!');
                        //loadCalendar();
                    } else {
                        console.log('Lỗi gì đó...');
                        $(this).removeClass('pending-checkout').text('Check out');
                    }
                },
                error: function (){
                    console.log('Error');
                }
            });
        }
    })
});
