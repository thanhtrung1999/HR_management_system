<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function addCheckIn($employeeId, $checkinTime){
        $workingDaysModel = new WorkingDays();
        $workingDaysModel->employee_id = $employeeId;
        $workingDaysModel->checkin_time = $checkinTime;
        $workingDaysModel->save();

        if($workingDaysModel->id){
            return true;
        } else {
            return false;
        }
    }
}
