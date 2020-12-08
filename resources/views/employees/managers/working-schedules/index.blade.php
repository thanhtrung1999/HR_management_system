@extends('layout.master')
@section('title', 'Quản lý lịch làm việc của nhân viên')
@section('breadcrumb')
    <a href="{{route('manager.getWorkSchedule')}}" class="nav-link">Quản lý lịch làm việc của nhân viên</a>
@endsection
@section('active-link-working-schedule', 'active')
@section('content')
    <h2>Thống kê lịch làm việc của nhân viên</h2>
    <div class="table-content mt-4">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Chức vụ</th>
                    <th>Phòng ban</th>
                    <th>Số ngày làm trong tháng</th>
                    <th>Số giờ làm trong tháng</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if($totalEmployeesWorkTime->isNotEmpty())
                @foreach($totalEmployeesWorkTime as $index => $totalEmployeeWorkTime)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$totalEmployeeWorkTime->first_name}} {{$totalEmployeeWorkTime->last_name}}</td>
                        <td>{{$totalEmployeeWorkTime->email}}</td>
                        <td>{{$totalEmployeeWorkTime->position}}</td>
                        <td>{{$totalEmployeeWorkTime->department_name}}</td>
                        <td>{{$totalEmployeeWorkTime->work_days_in_month}}</td>
                        {{--<td>{{gmdate("H:m", $totalEmployeeWorkTime->work_hours_in_month*3600)}}</td>--}}
                        <td>{{$totalEmployeeWorkTime->work_hours_in_month}}</td>
                        <td><a href="{{route('manager.getDetailWorkSchedule', ['id'=>$totalEmployeeWorkTime->employee_id])}}"><i class="fas fa-eye"></i></a></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8"><h3 class="text-center p-4">Không có dữ liệu</h3></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
