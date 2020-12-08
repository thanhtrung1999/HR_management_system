<?php

namespace App\Http\Controllers\Employee\Manager;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManagedEmployeeWorkScheduleController extends Controller
{
    public function getEmployeesWorkSchedule()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $managerId = auth('employees')->user()->id;
        $totalEmployeesWorkTime = $this->workingDaysModel->getTotalEmployeesWorkTime($managerId, $month, $year);
        return view('employees.managers.working-schedules.index', [
            'totalEmployeesWorkTime' => $totalEmployeesWorkTime
        ]);
    }

    public function getDetailWorkScheduleOfEmployee($id)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $managerId = auth('employees')->user()->id;

        $daysInMonth = Carbon::now()->daysInMonth;
        $days = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = (string)$i;
            if (strlen($date) == 1) {
                $date = "0$date";
            }
            $days[] = "$year-$month-$date";
        }

        $totalEmployeeWorkTime = $this->workingDaysModel->getTotalEmployeeWorkTimeByEmployeeId($id, $managerId, $month, $year);
        $employeeWorkSchedulesInMonth = $this->workingDaysModel->getEmployeeWorkSchedulesInMonth($id, $month, $year);

        $requestsForLeave = $this->requestModel->getApprovedRequests($id);
//        dd($requestsForLeave);
        return view('employees.managers.working-schedules.detail', [
            'days' => $days,
            'month' => $month,
            'year' => $year,
            'totalEmployeeWorkTime' => $totalEmployeeWorkTime,
            'employeeWorkSchedulesInMonth' => $employeeWorkSchedulesInMonth,
            'requestsForLeave' => $requestsForLeave
        ]);
    }
}
