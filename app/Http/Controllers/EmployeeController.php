<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function getCalendar(){
        return view('index');
    }

    public function getRequests(){
        return view('employees.requests.index');
    }

    public function getRequestsApproval(){
        return view('employees.requests-approval');
    }

    public function getEmployees(){
        return view('employees.managers.employees.index');
    }

    public function getWorkingSchedule(){
        return view('employees.managers.employees.working-schedule');
    }
}
