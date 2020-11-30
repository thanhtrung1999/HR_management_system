@extends('layout.master')
@section('title', 'Lịch làm việc')
@section('active-link-calendar', 'active')
@section('content')
    <div class="container-calendar">

        <div class="calendar-header row mb-3">
            <h3 class="col-md-6" id="monthAndYear"></h3>
            <div class="col-md-6 btn-in-out">
                <button class="float-right btn btn-secondary btn-check-in">Check in</button>
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
