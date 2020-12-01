@extends('layout.master')
@section('title', 'Lịch làm việc')
@section('active-link-calendar', 'active')
@section('breadcrumb')
    <a href="" class="nav-link">Lịch làm việc</a>
@endsection
@section('content')
    <div class="container-calendar">

        <div class="calendar-header position-relative row mb-3">
            <h3 id="monthAndYear"></h3>
            <div class="btn-in-out">
                <button class="btn btn-secondary" onclick="atNow()">Today</button>
                <button class="btn btn-secondary ml-2 btn-check-in">Check in</button>
            </div>
        </div>

        <div class="button-container-calendar">
            <button id="previous" onclick="previous()">&#8249;</button>
            <button id="next" onclick="next()">&#8250;</button>
        </div>

        <table class="table-calendar" id="calendar" data-lang="en">
            <thead id="thead-month"></thead>
            <tbody id="calendar-body"></tbody>
        </table>

        <div class="footer-container-calendar">
            <label for="month">Jump To: </label>
            <select id="month" onchange="jump()">
                <option value=0>Jan</option>
                <option value=1>Feb</option>
                <option value=2>Mar</option>
                <option value=3>Apr</option>
                <option value=4>May</option>
                <option value=5>Jun</option>
                <option value=6>Jul</option>
                <option value=7>Aug</option>
                <option value=8>Sep</option>
                <option value=9>Oct</option>
                <option value=10>Nov</option>
                <option value=11>Dec</option>
            </select>
            <select id="year" onchange="jump()"></select>
        </div>

    </div>
@endsection
@section('script')
    <script src="js/load-calendar.js"></script>
@endsection
