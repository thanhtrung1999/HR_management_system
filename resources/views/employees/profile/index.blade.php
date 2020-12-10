@extends('layout.master')
@section('title', 'Profile')
@section('breadcrumb')
    <a href="{{route('profile.index')}}" class="nav-link">Profile</a>
@endsection
@section('content')
    <div class="profile-wrapper">
        <h4>Profile</h4>
        <div class="profile-content">
            <a class="btn btn-info mb-4" href="{{route('profile.edit', ['profile' => auth('employees')->user()->id])}}">Edit</a>
            <div class="profile-content__table">
                <table class="table table-hover table-bordered">
                    <tr>
                        <td><b>Email</b></td>
                        <td>{{auth('employees')->user()->email}}</td>
                    </tr>
                    <tr>
                        <td><b>Họ tên</b></td>
                        <td>{{auth('employees')->user()->first_name}} {{auth('employees')->user()->last_name}}</td>
                    </tr>
                    <tr>
                        <td><b>Chức vụ</b></td>
                        <td>{{auth('employees')->user()->position}}</td>
                    </tr>
                    <tr>
                        <td><b>Giới tính</b></td>
                        @if(auth('employees')->user()->gender == 1)
                            <td>Nam</td>
                        @else
                            <td>Nữ</td>
                        @endif
                    </tr>
                    <tr>
                        <td><b>Địa chỉ</b></td>
                        <td>{{auth('employees')->user()->address}}</td>
                    </tr>
                    <tr>
                        <td><b>Phone</b></td>
                        <td>{{auth('employees')->user()->phone_number}}</td>
                    </tr>
                    <tr>
                        <td><b>Ngày sinh</b></td>
                        <td>{{auth('employees')->user()->birthday}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
