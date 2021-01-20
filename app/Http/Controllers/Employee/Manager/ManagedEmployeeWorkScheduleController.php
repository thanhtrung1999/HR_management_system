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
            $date = str_pad((string)$i, 2, "0", STR_PAD_LEFT);
            $days[] = "$year-$month-$date";
        }

        /* Lấy ra các ngày cuối tuần trong tháng */
        $collectionDays = collect($days);
        $filteredDayWeekend = $collectionDays->filter(function ($value) {
            return Carbon::parse($value)->isWeekend();
        });
        $daysWeekend = $filteredDayWeekend->all();

        /* Lấy ra tổng số thời gian làm việc trong tháng */
        $totalEmployeeWorkTime = $this->workingDaysModel->getTotalEmployeeWorkTimeByEmployeeId($id, $managerId, $month, $year);

        /* Lấy ra các ngày làm việc trong tháng của nhân viên */
        $employeeWorkSchedulesInMonth = $this->workingDaysModel->getEmployeeWorkSchedulesInMonth($id, $month, $year);
        $workDays = $this->getWorkDays($employeeWorkSchedulesInMonth);

        /* Lấy ra các ngày nghỉ có phép trong tháng*/
        $approvedRequests = $this->requestModel->getApprovedRequests($id);
        $daysOff = $this->getDaysOff($approvedRequests);
        $authorizedLeavesInCurrentMonth = $this->getAuthorizedLeavesInCurrentMonth($daysOff);
//        dd($approvedRequests, $daysOff, $authorizedLeavesInCurrentMonth);

        /* Lấy ra các ngày nghỉ không phép */
        $unauthorizedLeaves = array_diff($days, $workDays, $daysWeekend, $authorizedLeavesInCurrentMonth);
        $collectionUnauthorizedLeaves = collect($unauthorizedLeaves);
        $filteredUnauthorizedLeaves = $collectionUnauthorizedLeaves->filter(function ($value, $key) {
            return Carbon::parse($value)->day <= Carbon::now()->day;
        });
        $unauthorizedLeaves = $filteredUnauthorizedLeaves->all();

        /* Tạo session lưu data */
        $data = [
            'days' => $days,
            'month' => $month,
            'year' => $year,
            'totalEmployeeWorkTime' => $totalEmployeeWorkTime,
            'workDays' => $employeeWorkSchedulesInMonth,
            'detailAuthorizedLeaves' => $authorizedLeavesInCurrentMonth,
            'unauthorizedLeaves' => $unauthorizedLeaves,
        ];
        session()->put('data_timesheet', $data);
        return view('employees.managers.working-schedules.detail', $data);
    }

    public function exportTimeSheetEmployees()
    {
        return Excel::download(new TimeSheetExportView(), 'timesheet.xlsx');
    }

    private function getWorkDays($employeeWorkSchedulesInMonth)
    {
        $workDays = [];
        foreach ($employeeWorkSchedulesInMonth as $workDay) {
            $workDays[] = $workDay->working_on_day;
        }
        return $workDays;
    }

    private function getDaysOff($approvedRequests)
    {
        $daysOff = [];
        foreach ($approvedRequests as $request) {
            $dateAt = Carbon::parse($request->start_at)->format('Y-m-d');
            $dateEnd = Carbon::parse($request->end_at)->format('Y-m-d');
            $timeDateAt = Carbon::parse($request->start_at)->format('H:i');
            $timeDateEnd = Carbon::parse($request->end_at)->format('H:i');

            if (Carbon::parse($dateEnd)->month == Carbon::parse($dateAt)->month) {
                for ($day = $dateAt; $day <= $dateEnd; $day++) {
                    if ($day == $dateAt && Carbon::parse("$day $timeDateAt")->isAfter("$day 17:29:59")) {
                        continue;
                    }
                    if ($day == $dateEnd && Carbon::parse("$day $timeDateEnd")->isBefore("$day 08:30:00")) {
                        break;
                    }
                    $daysOff[] = $day;
                }
            } elseif (Carbon::parse($dateEnd)->month > Carbon::parse($dateAt)->month) {
                $dateEndCurrentMonth = Carbon::parse($dateAt)->endOfMonth()->toDateString();
                $dateAtNextMonth = Carbon::parse($dateEnd)->firstOfMonth()->toDateString();

                for ($day = $dateAt; $day <= $dateEndCurrentMonth; $day++) {
                    if ($day == $dateAt && Carbon::parse("$day $timeDateAt")->isAfter("$day 17:29:59")) {
                        continue;
                    }
                    if ($day == $dateEndCurrentMonth && Carbon::parse("$day $timeDateEnd")->isBefore("$day 08:30:00")) {
                        break;
                    }
                    $daysOff[] = $day;
                }

                for ($day = $dateAtNextMonth; $day <= $dateEnd; $day++) {
                    if ($day == $dateAt && Carbon::parse("$day $timeDateAt")->isAfter("$day 17:29:59")) {
                        continue;
                    }
                    if ($day == $dateEndCurrentMonth && Carbon::parse("$day $timeDateEnd")->isBefore("$day 08:30:00")) {
                        break;
                    }
                    $daysOff[] = $day;
                }
            }
        }
        return $daysOff;
    }

    private function getAuthorizedLeavesInCurrentMonth($daysOff)
    {
        $collectionDaysOff = collect($daysOff);
        $authorizedLeavesInCurrentMonth = $collectionDaysOff->filter(function ($value) {
            $daysOffMonth = Carbon::parse($value)->format('m');
            $daysOffYear = Carbon::parse($value)->format('Y');

            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');

            if ($daysOffMonth == $month && $daysOffYear == $year) {
                return !Carbon::parse($value)->isWeekend();
            }
        });

        return $authorizedLeavesInCurrentMonth->all();
    }
}
