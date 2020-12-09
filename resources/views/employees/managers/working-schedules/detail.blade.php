@extends('layout.master')
@section('title', 'Quản lý lịch làm việc của nhân viên')
@section('breadcrumb')
    <a href="{{route('manager.getWorkSchedule')}}" class="nav-link">Quản lý lịch làm việc của nhân viên</a>
@endsection
@section('active-link-working-schedule', 'active')
@section('content')
    @include('employees.managers.working-schedules.timesheet')
@endsection
