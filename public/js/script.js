$(document).ready(function (){
    let base_url = $('base').attr('href');
    let today = new Date();
    let date = today.getDate();
    let month = today.getMonth()+1;
    let year = today.getFullYear();
    let hour = today.getHours();
    let minutes = today.getMinutes();
    let seconds = today.getSeconds();

    $('.container-calendar .calendar-header .btn-check-in').click(function (){
        console.log(`${base_url}check-in\n${today}`);

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
            success: function (response){
                load_calendar();
                if(parseInt(response) === 1){
                    console.log('Done!');
                } else {
                    console.log('Lỗi gì đó...');
                }
            },
            error: function (){
                console.log('Error');
            }
        });
    });

    // $('.container-calendar .calendar-header .btn-check-out').click(function (){
    //     alert('Done!');
    // });
    $(document).on('click', '.btn-check-out', function () {
        console.log(`${base_url}check-out\n${today}`);

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
            success: function (response){
                load_calendar();
                if(parseInt(response) === 1){
                    console.log('Done!');
                } else {
                    console.log('Lỗi gì đó...');
                }
            },
            error: function (){
                console.log('Error');
            }
        });

    })
});
