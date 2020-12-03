@extends('layout.master')
@section('title', 'Quản lý nhân viên')
@section('breadcrumb')
    <a href="{{route('manager.listEmployees')}}" class="nav-link">Quản lý nhân viên</a>
@endsection
@section('active-link-list-employees', 'active')
@section('content')
    @include('employees.managers.employees.contents.list-employee')
@endsection
