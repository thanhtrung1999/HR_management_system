const baseUrl = $('base').attr('href')

export default {
    routes: {
        api: {
            loadCalendar: `${baseUrl}api/load-calendar`,
            checkIn: `${baseUrl}api/check-in`,
            checkOut: `${baseUrl}api/check-out`,
            createEmployeeRequest: `${baseUrl}api/employee/requests/create`
        }
    }
}
