<?php

namespace App\Http\Controllers\Employee\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagedEmployeeWorkScheduleController extends Controller
{
    public $countDay;
    public $countTime;

    public function getEmployeeWorkSchedule(){
        $workingDays = $this->workingDaysModel->getEmployeeWorkDays(5, 12);
        $requestForLeave = $this->requestModel->getApprovedRequest(5);
        dd($requestForLeave);

        $this->countDay = count($workingDays);
        $this->countTime = 0;

        foreach ($workingDays as $workingDay){
            $checkin_time = $workingDay->checkin_time;
            $checkout_time = $workingDay->checkout_time;
            if (!empty($checkout_time)){
                $checkin_date = $checkin_time . ' ' . $workingDay->working_on_day;
                $checkout_date = $checkout_time . ' ' . $workingDay->working_on_day;
                $checkin_timestamp = strtotime($checkin_date);
                $checkout_timestamp = strtotime($checkout_date);
                $workingHourOnDay = round(abs($checkout_timestamp - $checkin_timestamp)/(60*60) - 1);
                $this->countTime += $workingHourOnDay;
            }
        }
        dd($this->countTime);
        return view('employees.managers.working-schedules.index');
    }
}
