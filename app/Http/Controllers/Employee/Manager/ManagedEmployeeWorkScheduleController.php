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
        $month = Carbon::now()->month;
        if (strlen((string)$month) == 1) {
            $month = "0$month";
        }
        $year = Carbon::now()->year;
        $managerId = auth('employees')->user()->id;

        /* Lấy ra các ngày trong tháng */
        $daysInMonth = Carbon::now()->daysInMonth;
        $days = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = (string)$i;
            if (strlen($date) == 1) {
                $date = "0$date";
            }
            $days[] = "$year-$month-$date";
        }

        /* Lấy ra các ngày cuối tuần trong tháng */
        $collectionDays = collect($days);
        $filteredDayWeekend = $collectionDays->filter(function ($value, $key) {
            $day = Carbon::parse($value);
            return $day->isSaturday() || $day->isSunday();
        });
        $daysWeekend = $filteredDayWeekend->all();

        /* Lấy ra tổng số thời gian làm việc trong tháng */
        $totalEmployeeWorkTime = $this->workingDaysModel->getTotalEmployeeWorkTimeByEmployeeId($id, $managerId, $month, $year);

        /* Lấy ra các ngày làm việc trong tháng của nhân viên */
        $employeeWorkSchedulesInMonth = $this->workingDaysModel->getEmployeeWorkSchedulesInMonth($id, $month, $year);
        $workDays = [];
        foreach ($employeeWorkSchedulesInMonth as $workDay) {
            $workDays[] = $workDay->working_on_day;
        }

        /* Lấy ra các ngày nghỉ có phép */
        $requestsForLeave = $this->requestModel->getApprovedRequests($id);
//        dd($requestsForLeave);

        $authorizedLeaves = [];
        foreach ($requestsForLeave as $request) {
            $dayOffAt = Carbon::parse($request->start_at)->format('Y-m-d');
            $dayOffEnd = Carbon::parse($request->end_at)->format('Y-m-d');
            $timeDayOffAt = Carbon::parse($request->start_at)->format('H:i');
            $timeDayOffEnd = Carbon::parse($request->end_at)->format('H:i');
            $authorizedLeaves[] = [
                'start_at' => [
                    'date' => $dayOffAt,
                    'time' => $timeDayOffAt
                ],
                'end_at' => [
                    'date' => $dayOffEnd,
                    'time' => $timeDayOffEnd
                ]
            ];
        }
//        dd($authorizedLeaves);
        $detailAuthorizedLeaves = [];
        foreach ($authorizedLeaves as $authorizedLeave) {
            $dateAt = $authorizedLeave['start_at']['date'];
            $dateEnd = $authorizedLeave['end_at']['date'];
            $timeDateAt = $authorizedLeave['start_at']['time'];
            $timeDateEnd = $authorizedLeave['end_at']['time'];

            if (Carbon::parse($dateEnd)->month == Carbon::parse($dateAt)->month) {
                for ($day = $dateAt; $day <= $dateEnd; $day++) {
                    if ($day == $dateAt) {
                        if (Carbon::parse($day . ' ' . $timeDateAt)->isAfter("$day 17:29:59")) {
                            $day++;
                        }
                    }
                    if ($day == $dateEnd) {
                        if (Carbon::parse($day . ' ' . $timeDateEnd)->isBefore("$day 08:30:00")) {
                            break;
                        }
                    }
                    $detailAuthorizedLeaves[] = $day;
                }
            } else if (Carbon::parse($dateEnd)->month > Carbon::parse($dateAt)->month) {
                $yearDateEnd = (string)Carbon::parse($dateEnd)->year;
                $monthDateEnd = (string)Carbon::parse($dateEnd)->month;
                if (strlen((string)$monthDateEnd) == 1) {
                    $monthDateEnd = "0$monthDateEnd";
                }
                $dateAt = "$yearDateEnd-$monthDateEnd-01";

                for ($day = $dateAt; $day <= $dateEnd; $day++) {
                    if ($day == $dateAt) {
                        if (Carbon::parse($day . ' ' . $timeDateAt)->isAfter("$day 17:29:59")) {
                            $day++;
                        }
                    }
                    if ($day == $dateEnd) {
                        if (Carbon::parse($day . ' ' . $timeDateEnd)->isBefore("$day 08:30:00")) {
                            break;
                        }
                    }
                    $detailAuthorizedLeaves[] = $day;
                }
            }
        }

        $collectionDetailAuthorizedLeaves = collect($detailAuthorizedLeaves);
        $detailAuthorizedLeavesAtNow = $collectionDetailAuthorizedLeaves->filter(function ($value, $key) {
            $dayOffMonth = Carbon::parse($value)->month;
            $dayOffYear = Carbon::parse($value)->year;

            $month = Carbon::now()->month;
            if (strlen((string)$month) == 1) {
                $month = "0$month";
            }
            $year = Carbon::now()->year;

            if ($dayOffMonth == $month && $dayOffYear == $year) {
                return $value;
            }
        });
//        dd($authorizedLeaves, $detailAuthorizedLeavesAtNow);
        /* Lấy ra các ngày nghỉ không phép */
        $unauthorizedLeaves = array_diff($days, $workDays, $daysWeekend, $detailAuthorizedLeaves);
        $collectionUnauthorizedLeaves = collect($unauthorizedLeaves);
        $filteredUnauthorizedLeaves = $collectionUnauthorizedLeaves->filter(function ($value, $key) {
            $day = Carbon::parse($value);
            return $day->day <= Carbon::now()->day;
        });
        $unauthorizedLeaves = $filteredUnauthorizedLeaves->all();
//        dd($detailAuthorizedLeaves, $unauthorizedLeaves);

        $data = [
            'days' => $days,
            'month' => $month,
            'year' => $year,
            'totalEmployeeWorkTime' => $totalEmployeeWorkTime,
            'workDays' => $employeeWorkSchedulesInMonth,
            'authorizedLeaves' => $authorizedLeaves,
            'detailAuthorizedLeaves' => $detailAuthorizedLeavesAtNow,
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
