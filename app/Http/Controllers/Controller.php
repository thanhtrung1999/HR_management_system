<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Root;
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
     * Controller constructor.
     * @param Root $rootModel
     * @param Employee $employeeModel
     * @param Department $departmentModel
     */
    public function __construct(Root $rootModel, Employee $employeeModel, Department $departmentModel)
    {
        $this->rootModel = $rootModel;
        $this->employeeModel = $employeeModel;
        $this->departmentModel = $departmentModel;
    }
}
