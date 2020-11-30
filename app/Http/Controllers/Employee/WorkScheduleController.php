<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Root;
use App\Models\WorkingDays;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkScheduleController extends Controller
{
    protected $workingDaysModel;

    public function __construct(
        Root $rootModel,
        Employee $employeeModel,
        Department $departmentModel,
        WorkingDays $workingDaysModel)
    {
        parent::__construct($rootModel, $employeeModel, $departmentModel);
        $this->workingDaysModel = $workingDaysModel;
    }

    public function index()
    {
        return view('index');
    }

    public function checkIn(Request $request){
        $employeeId = Auth::guard('employees')->user()->id;
        $dataCheckin = $this->workingDaysModel->addCheckIn($employeeId, Carbon::parse($request['fulltime']));

        echo $dataCheckin;
    }

    public function checkOut(){

    }
}
