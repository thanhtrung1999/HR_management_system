<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkScheduleController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function checkIn(Request $request)
    {
        $employeeId = Auth::guard('employees')->user()->id;
        $checkInNow = $this->workingDaysModel->isCheckinNow($employeeId, now()->format('Y-m-d'));
        if ($checkInNow == 0) {
            $dataCheckin = $this->workingDaysModel->addCheckIn($employeeId, $request['day'], $request['time']);
            echo $dataCheckin;
        } else {
            echo 'Hôm nay đã checkin';
        }
    }

    public function checkInAPI(Request $request)
    {
        $employeeId = $request->get('employeeId');
        if (Carbon::parse($request['day'])->isWeekend()) {
            echo "Hôm nay là cuối tuần";
        } else {
            $checkInNow = $this->workingDaysModel->isCheckinNow($employeeId, now()->format('Y-m-d'));
            if ($checkInNow == 0) {
                $dataCheckin = $this->workingDaysModel->addCheckIn($employeeId, $request['day'], $request['time']);
                echo $dataCheckin;
            } else {
                echo 'Hôm nay đã checkin';
            }
        }
    }

    public function loadCalendar()
    {
        $employeeId = Auth::guard('employees')->user()->id;
        $data = $this->workingDaysModel->getWorkingDaysByEmployeeId($employeeId);

        echo json_encode($data);
    }

    public function loadCalendarAPI(Request $request)
    {
        $employeeId = $request->get('employeeId');
        $data = $this->workingDaysModel->getWorkingDaysByEmployeeId($employeeId);

        echo json_encode($data);
    }

    public function checkOut(Request $request)
    {
        $employeeId = Auth::guard('employees')->user()->id;
        $workingDay = $this->workingDaysModel->getWorkingDay($employeeId, $request['day']);
        $checkoutNow = $this->workingDaysModel->isCheckoutNow($employeeId, $request['day']);

        if ($checkoutNow != 0) {
            $dataCheckout = $this->workingDaysModel->addCheckOut($workingDay->id, $request['time']);
            echo $dataCheckout;
        } else {
            echo 'Hôm nay đã checkout';
        }
    }

    public function checkOutAPI(Request $request)
    {
        $employeeId = $request->get('employeeId');
        if (Carbon::parse($request['day'])->isWeekend()) {
            echo "Hôm nay là cuối tuần";
        } else {
            $workingDay = $this->workingDaysModel->getWorkingDay($employeeId, $request['day']);
            $checkoutNow = $this->workingDaysModel->isCheckoutNow($employeeId, $request['day']);

            if ($checkoutNow != 0) {
                $dataCheckout = $this->workingDaysModel->addCheckOut($workingDay->id, $request['time']);
                echo $dataCheckout;
            } else {
                echo 'Hôm nay đã checkout';
            }
        }
    }
}
