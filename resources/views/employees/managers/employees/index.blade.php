@extends('layout.master')
@section('title', 'Quản lý nhân viên')
@section('breadcrumb')
    <a href="{{route('manager.listEmployees')}}" class="nav-link">Quản lý nhân viên</a>
@endsection
@section('active-link-list-employees', 'active')
@section('content')
    <h2>Danh sách nhân viên</h2>
    <a href="{{route('manager.exportEmployee')}}" class="btn btn-dark">Export</a>
    @include('employees.managers.employees.contents.list-employee')
@endsection
