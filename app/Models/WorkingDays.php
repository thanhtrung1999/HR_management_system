<?php

namespace App\Models;

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

    public function employee(){
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }

    public function addCheckIn($employeeId, $checkinDay, $checkinTime){
        $workingDaysModel = new WorkingDays();
        $workingDaysModel->employee_id = $employeeId;
        $workingDaysModel->working_on_day = $checkinDay;
        $workingDaysModel->checkin_time = $checkinTime;
        $workingDaysModel->save();

        if($workingDaysModel->id){
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

    public function isCheckoutNow($employeeId, $dayNow){
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

        if ($workingDay->checkout_time != null){
            return true;
        } else {
            return false;
        }
    }

    public function getEmployeeWorkDays($employeeId, $month)
    {
        return DB::table('working_days')
            ->where('employee_id', '=', $employeeId)
            ->whereRaw("MONTH(`working_on_day`) = $month")
            ->get();
    }
}
