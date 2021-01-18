<?php

namespace App\Http\Controllers\Employee\Manager;

use App\Exports\TimeSheetExportView;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManagedEmployeeWorkScheduleController extends Controller
{
    public function getEmployeesWorkSchedule()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $managerId = auth('employees')->user()->id;
        $totalEmployeesWorkTime = $this->workingDaysModel->getTotalEmployeesWorkTime($managerId, $month, $year);
//        dd($totalEmployeesWorkTime);
        return view('employees.managers.working-schedules.index', [
            'totalEmployeesWorkTime' => $totalEmployeesWorkTime
        ]);
    }

    public function getDetailWorkScheduleOfEmployee($id)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $managerId = auth('employees')->user()->id;

        /* Lấy ra các ngày trong tháng */
        $daysInMonth = Carbon::now()->daysInMonth;
        $days = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = (string)$i;
            $date = str_pad($date, 2, "0", STR_PAD_LEFT);
            $days[] = "$year-$month-$date";
        }

        /* Lấy ra các ngày cuối tuần trong tháng */
        $collectionDays = collect($days);
        $filteredDayWeekend = $collectionDays->filter(function ($value) {
            $day = Carbon::parse($value);
            return $day->isSaturday() || $day->isSunday();
        });
        $daysWeekend = $filteredDayWeekend->all();

        /* Lấy ra tổng số thời gian làm việc trong tháng */
        $totalEmployeeWorkTime = $this->workingDaysModel->getTotalEmployeeWorkTimeByEmployeeId($id, $managerId, $month, $year);

        /* Lấy ra các ngày làm việc trong tháng của nhân viên */
        $employeeWorkSchedulesInMonth = $this->workingDaysModel->getEmployeeWorkSchedulesInMonth($id, $month, $year);
        $workDays = $this->workingDaysModel->getWorkDays($employeeWorkSchedulesInMonth);

        /* Lấy ra các ngày nghỉ có phép */
        $approvedRequests = $this->requestModel->getApprovedRequests($id);
        $daysOffInterval = $this->workingDaysModel->getDaysOffInterval($approvedRequests);
        $daysOff = $this->workingDaysModel->getDaysOff($daysOffInterval, $daysInMonth);

        $collectionDaysOff = collect($daysOff);
        $daysOffInCurrentMonth = $collectionDaysOff->filter(function ($value, $key) {
            $daysOffMonth = Carbon::parse($value)->format('m');
            $daysOffYear = Carbon::parse($value)->format('Y');

            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');

            if ($daysOffMonth == $month && $daysOffYear == $year) {
                return $value;
            }
        })->all();
//        dd($approvedRequests, $daysOffInterval, $daysOff, $daysOffInCurrentMonth);

        /* Lấy ra các ngày nghỉ không phép */
        $unauthorizedLeaves = array_diff($days, $workDays, $daysWeekend, $daysOffInCurrentMonth);
        $collectionUnauthorizedLeaves = collect($unauthorizedLeaves);
        $filteredUnauthorizedLeaves = $collectionUnauthorizedLeaves->filter(function ($value, $key) {
            $day = Carbon::parse($value);
            return $day->day <= Carbon::now()->day;
        });
        $unauthorizedLeaves = $filteredUnauthorizedLeaves->all();

        /* Tạo session lưu data */
        $data = [
            'days' => $days,
            'month' => $month,
            'year' => $year,
            'totalEmployeeWorkTime' => $totalEmployeeWorkTime,
            'workDays' => $employeeWorkSchedulesInMonth,
            'daysOffInterval' => $daysOffInterval,
            'detailAuthorizedLeaves' => $daysOffInCurrentMonth,
            'unauthorizedLeaves' => $unauthorizedLeaves,
        ];
        session()->put('data_timesheet', $data);
        return view('employees.managers.working-schedules.detail', $data);
    }

    public function exportTimeSheetEmployees()
    {
        return Excel::download(new TimeSheetExportView(), 'timesheet.xlsx');
    }
}
