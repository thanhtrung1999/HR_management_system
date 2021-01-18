<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkingDays extends Model
{
    use HasFactory;

    protected $table = 'working_days';
    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'checkin_time',
        'checkout_time',
    ];

    private const USERTYPE_EMPLOYEE = 0;
    private const USERTYPE_MANAGER = 1;

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }

    public function addCheckIn($employeeId, $checkinDay, $checkinTime)
    {
        $workingDaysModel = new WorkingDays();
        $workingDaysModel->employee_id = $employeeId;
        $workingDaysModel->working_on_day = $checkinDay;
        $workingDaysModel->checkin_time = $checkinTime;
        $workingDaysModel->save();

        if ($workingDaysModel->id) {
            return true;
        } else {
            return false;
        }
    }

    public function getWorkingDaysByEmployeeId($employeeId)
    {
        return WorkingDays::where('employee_id', '=', $employeeId)->get();
    }

    public function isCheckinNow($employeeId, $dayNow)
    {
        return WorkingDays::where([
            ['employee_id', '=', $employeeId],
            ['working_on_day', '=', $dayNow]
        ])->count();
    }

    public function isCheckoutNow($employeeId, $dayNow)
    {
        return WorkingDays::where([
            ['employee_id', '=', $employeeId],
            ['working_on_day', '=', $dayNow],
            ['checkout_time', '=', null]
        ])->count();
    }

    public function getWorkingDay($employeeId, $day)
    {
        return WorkingDays::where([
            ['employee_id', '=', $employeeId],
            ['working_on_day', '=', $day]
        ])->first();
    }

    public function addCheckOut($id, $checkoutTime)
    {
        $workingDay = WorkingDays::find($id);
        $workingDay->checkout_time = $checkoutTime;
        $workingDay->save();

        if ($workingDay->checkout_time != null) {
            return true;
        } else {
            return false;
        }
    }

    public function getEmployeeWorkSchedulesInMonth($employeeId, $month, $year)
    {
        return DB::table('working_days')
            ->where('employee_id', '=', $employeeId)
            ->whereRaw("MONTH(`working_on_day`) = $month")
            ->whereRaw("YEAR(`working_on_day`) = $year")
            ->get();
    }

    public function getTotalEmployeesWorkTime($managerId, $month, $year)
    {
        return DB::table('employees')
            ->join('working_days', 'employees.id', '=', 'working_days.employee_id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->select(
                "employees.id as employee_id",
                'employees.first_name',
                'employees.last_name',
                'employees.email',
                'employees.position',
                'departments.name as department_name'
            )
            ->selectRaw("COUNT(DISTINCT working_on_day) as 'work_days_in_month'")
            ->selectRaw("(SUM(time_to_sec(TIMEDIFF(checkout_time, checkin_time)))/3600-1*COUNT(DISTINCT working_on_day)) as 'work_hours_in_month'")
            ->where('employees.user_type', '=', self::USERTYPE_EMPLOYEE)
            ->where('departments.employee_id', '=', $managerId)
            ->whereRaw("MONTH(`working_on_day`) = $month")
            ->whereRaw("YEAR(`working_on_day`) = $year")
            ->whereRaw("checkout_time is NOT NULL")
            ->groupBy('employees.id')
            ->get();
        /*$day = Carbon::now();
        $timesheet = WorkingDays::select('working_days.*',
            DB::raw('(TIMEDIFF(checkout_time, checkin_time)) as sum_time_work_day'),
            DB::raw('(TIME_TO_SEC(TIMEDIFF(checkout_time, checkin_time))) as second_time_in_work_day')
        )
            ->whereDate('working_on_day', '>=', $day->startOfMonth()->format('Y-m-d H:i:s'))
            ->whereDate('working_on_day', '<=', $day->endOfMonth()->format('Y-m-d H:i:s'))
            ->get()->groupBy('employee_id');
        dd($timesheet);*/
    }

    public function getTotalEmployeeWorkTimeByEmployeeId($employeeId, $managerId, $month, $year)
    {
        return DB::table('employees')
            ->join('working_days', 'employees.id', '=', 'working_days.employee_id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->select(
                "employees.id as employee_id",
                'employees.first_name',
                'employees.last_name',
                'employees.email',
                'employees.position',
                'departments.name as department_name'
            )
            ->selectRaw("COUNT(DISTINCT working_on_day) as 'work_days_in_month'")
            ->selectRaw("(SUM(time_to_sec(TIMEDIFF(checkout_time, checkin_time)))/3600-1*COUNT(DISTINCT working_on_day)) as 'work_hours_in_month'")
            ->where('employees.user_type', '=', self::USERTYPE_EMPLOYEE)
            ->where('employees.id', '=', $employeeId)
            ->where('departments.employee_id', '=', $managerId)
            ->whereRaw("MONTH(`working_on_day`) = $month")
            ->whereRaw("YEAR(`working_on_day`) = $year")
            ->whereRaw("checkout_time is NOT NULL")
            ->groupBy('employees.id')
            ->first();
    }

    public function getWorkDays($employeeWorkSchedulesInMonth)
    {
        $workDays = [];
        foreach ($employeeWorkSchedulesInMonth as $workDay) {
            $workDays[] = $workDay->working_on_day;
        }
        return $workDays;
    }

    public function getDaysOffInterval($approvedRequests)
    {
        $daysOffInterval = [];
        foreach ($approvedRequests as $request) {
            $dayOffAt = Carbon::parse($request->start_at)->format('Y-m-d');
            $dayOffEnd = Carbon::parse($request->end_at)->format('Y-m-d');
            $timeDayOffAt = Carbon::parse($request->start_at)->format('H:i');
            $timeDayOffEnd = Carbon::parse($request->end_at)->format('H:i');
            $daysOffInterval[] = [
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

        return $daysOffInterval;
    }

    public function getDaysOff($daysOffInterval, $daysInMonth)
    {
        $daysOff = [];
        foreach ($daysOffInterval as $dayOffInterval) {
            $dateAt = $dayOffInterval['start_at']['date'];
            $dateEnd = $dayOffInterval['end_at']['date'];
            $timeDateAt = $dayOffInterval['start_at']['time'];
            $timeDateEnd = $dayOffInterval['end_at']['time'];

            if (Carbon::parse($dateEnd)->month == Carbon::parse($dateAt)->month) {
                for ($day = $dateAt; $day <= $dateEnd; $day++) {
                    if ($day == $dateAt && Carbon::parse($day . ' ' . $timeDateAt)->isAfter("$day 17:29:59")) {
                        continue;
                    }
                    if ($day == $dateEnd && Carbon::parse($day . ' ' . $timeDateEnd)->isBefore("$day 08:30:00")) {
                        break;
                    }
                    $daysOff[] = $day;
                }
            } elseif (Carbon::parse($dateEnd)->month > Carbon::parse($dateAt)->month) {
                $yearDateAt = Carbon::parse($dateAt)->format('Y');
                $monthDateAt = Carbon::parse($dateAt)->format('m');
                $monthDateEnd = Carbon::parse($dateEnd)->format('m');

                $dateEndCurrentMonth = "$yearDateAt-$monthDateAt-$daysInMonth";
                $dateAtNextMonth = "$yearDateAt-$monthDateEnd-01";

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
}
