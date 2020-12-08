<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Request;
use App\Models\Root;
use App\Models\WorkingDays;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var Root
     */
    protected $rootModel;

    /**
     * @var Employee
     */
    protected $employeeModel;

    /**
     * @var Department
     */
    protected $departmentModel;

    /**
     * @var WorkingDays
     */
    protected $workingDaysModel;

    /**
     * @var Request
     */
    protected $requestModel;

    /**
     * Controller constructor.
     * @param Root $rootModel
     * @param Employee $employeeModel
     * @param Department $departmentModel
     * @param WorkingDays $workingDaysModel
     * @param Request $requestModel
     */
    public function __construct(
        Root $rootModel,
        Employee $employeeModel,
        Department $departmentModel,
        WorkingDays $workingDaysModel,
        Request $requestModel
    ) {
        $this->rootModel = $rootModel;
        $this->employeeModel = $employeeModel;
        $this->departmentModel = $departmentModel;
        $this->workingDaysModel = $workingDaysModel;
        $this->requestModel = $requestModel;
    }
}
