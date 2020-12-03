@extends('layout.master')
@section('title', 'Quản lý nhân viên')
@section('breadcrumb')
    <a href="{{route('manager.listEmployees')}}" class="pr-2 nav-link d-inline-block">Quản lý nhân viên</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{route('manager.detailEmployee', ['id' => $employee->id])}}" class="pl-2 nav-link d-inline-block">Thông tin</a>
@endsection
@section('active-link-list-employees', 'active')
@section('content')
    <div class="employee-info-wrapper">
        <h4>Thông tin nhân viên</h4>
        <div class="employee-info__table">
            <table class="table table-bordered">
                <tr>
                    <td><b>Họ tên</b></td>
                    <td>{{$employee->first_name}} {{$employee->last_name}}</td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td>{{$employee->email}}</td>
                </tr>
                <tr>
                    <td><b>Chức vụ</b></td>
                    <td>{{$employee->position}}</td>
                </tr>
                <tr>
                    <td><b>Avatar</b></td>
                    <td><img style="width: 9rem" src="{{empty($employee->avatar) ? 'http://www.clker.com/cliparts/d/L/P/X/z/i/no-image-icon-hi.png' : 'images/uploads/'.$employee->avatar}}" alt="Avatar"></td>
                </tr>
                <tr>
                    <td><b>Giới tính</b></td>
                    @if($employee->gender == 1)
                        <td>Nam</td>
                    @else
                        <td>Nữ</td>
                    @endif
                </tr>
                <tr>
                    <td><b>Số điện thoại</b></td>
                    <td>{{$employee->phone_number}}</td>
                </tr>
                <tr>
                    <td><b>Địa chỉ</b></td>
                    <td>{{$employee->address}}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
