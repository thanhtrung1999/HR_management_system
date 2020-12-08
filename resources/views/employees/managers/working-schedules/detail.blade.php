@extends('layout.master')
@section('title', 'Quản lý lịch làm việc của nhân viên')
@section('breadcrumb')
    <a href="{{route('manager.getWorkSchedule')}}" class="nav-link">Quản lý lịch làm việc của nhân viên</a>
@endsection
@section('active-link-working-schedule', 'active')
@section('content')
    <h3 class="text-center">Lịch làm việc tháng {{$month}}-{{$year}}</h3>
    <div class="header-content mt-4">
        <div class="row">
            <div class="col-md-6">
                <p><b>Tên nhân viên</b>: <span>{{$totalEmployeeWorkTime->first_name}} {{$totalEmployeeWorkTime->last_name}}</span></p>
                <p><b>Email</b>: <span>{{$totalEmployeeWorkTime->email}}</span></p>
                <p><b>Chức vụ</b>: <span>{{$totalEmployeeWorkTime->position}}</span></p>
                <p><b>Phòng ban</b>: <span>{{$totalEmployeeWorkTime->department_name}}</span></p>
            </div>
            <div class="col-md-6">
                <p><b>Số ngày nghỉ</b>:</p>
            </div>
        </div>
    </div>
    <div class="table-content mt-4">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Thời gian check-in</th>
                    <th>Thời gian check-out</th>
                </tr>
            </thead>
            <tbody>
            @foreach($days as $index => $day)
                <tr>
                    <td>{{$day}}</td>
                    @php
                        $checkinTime = '';
                        $checkoutTime = '';
                        $daysOff = '';
                        if ($employeeWorkSchedulesInMonth->isNotEmpty()) {
                            foreach ($employeeWorkSchedulesInMonth as $workSchedule) {
                                if ($workSchedule->working_on_day == $day) {
                                    $checkinTime = $workSchedule->checkin_time;
                                    $checkoutTime = $workSchedule->checkout_time;
                                }
                            }
                        }
                    @endphp
                    <td>{{$checkinTime}}{{$daysOff}}</td>
                    <td>{{$checkoutTime}}{{$daysOff}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
