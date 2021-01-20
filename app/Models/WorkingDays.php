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
}
