@extends('layout.master')
@section('title', 'Lịch làm việc')
@section('stylesheet')
    <link rel="stylesheet" href="{{asset('css/calendar.css')}}" />
    <link rel="stylesheet" href="{{asset('css/css-loader.css')}}">
@endsection
@section('active-link-calendar', 'active')
@section('breadcrumb')
    <a href="" class="nav-link">Lịch làm việc</a>
@endsection
@section('content')
    <work-schedule-component :employeeId="{{auth('employees')->user()->id}}"></work-schedule-component>
@endsection
@section('script')
    <script src="{{asset('js/load-calendar.js')}}"></script>
    <script src="{{asset('js/calendar.js')}}"></script>
@endsection
