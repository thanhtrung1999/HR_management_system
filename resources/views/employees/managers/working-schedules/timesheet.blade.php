<h3 class="text-center">Lịch làm việc tháng {{$month}}-{{$year}}</h3>
<div class="header-content mt-4">
    <div class="row">
        <div class="col-md-6">
            <p><b>Tên nhân viên</b>: <span>{{$totalEmployeeWorkTime->first_name}} {{$totalEmployeeWorkTime->last_name}}</span></p>
            <p><b>Email</b>: <span>{{$totalEmployeeWorkTime->email}}</span></p>
            <p><b>Chức vụ</b>: <span>{{$totalEmployeeWorkTime->position}}</span></p>
            <p><b>Phòng ban</b>: <span>{{$totalEmployeeWorkTime->department_name}}</span></p>
            <p><b>Số ngày làm việc trong tháng</b>: <span>{{$totalEmployeeWorkTime->work_days_in_month}}</span></p>
            <p><b>Số giờ làm việc trong tháng</b>: <span>{{$totalEmployeeWorkTime->work_hours_in_month}}</span></p>
        </div>
        <div class="col-md-6">
            <p><b>Số ngày nghỉ</b>:</p>
            <p>Có phép: {{count($detailAuthorizedLeaves)}}</p>
            <p>Không phép: {{count($unauthorizedLeaves)}}</p>
        </div>
    </div>
</div>
<a href="{{route('manager.exportTimeSheetEmployees')}}" class="btn btn-dark">Export</a>
<div class="mt-4">
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
                $isUnauthorizedLeave = '';
                $isAuthorizedLeave = '';
                if (!empty($workDays)) {
                    foreach ($workDays as $workDay) {
                        if ($workDay->working_on_day == $day) {
                            $checkinTime = $workDay->checkin_time;
                            $checkoutTime = $workDay->checkout_time;
                        }
                    }
                }
                if (!empty($unauthorizedLeaves)) {
                    foreach ($unauthorizedLeaves as $unauthorizedLeaf) {
                        if ($unauthorizedLeaf == $day) {
                            $isUnauthorizedLeave = 'Nghỉ (không phép)';
                        }
                    }
                }
                if (!empty($detailAuthorizedLeaves)) {
                    foreach ($detailAuthorizedLeaves as $detailAuthorizedLeaf) {
                        if ($day == $detailAuthorizedLeaf) {
                            $isAuthorizedLeave = 'Nghỉ (có phép)';
                        }
                    }
                }
                @endphp
                <td>
                    <span class="checkin-time">{{$checkinTime}} </span>
                    <span class="authorized-leave">{{$isAuthorizedLeave}} </span>
                    <span class="unauthorized-leave">{{$isUnauthorizedLeave}}</span>
                </td>
                <td>
                    <span class="checkout-time">{{$checkoutTime}} </span>
                    <span class="authorized-leave">{{$isAuthorizedLeave}} </span>
                    <span class="unauthorized-leave">{{$isUnauthorizedLeave}}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
