<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Root;
use App\Models\Employee;
use App\Models\Department;
use App\Http\Requests\CreateDepartmentRequest;

class RootController extends Controller
{
    private $rootModel;
    private $employeeModel;
    private $departmentModel;

    public function __construct(Root $root_model, Employee $employee_model, Department $department_model)
    {
        $this->rootModel = $root_model;
        $this->employeeModel = $employee_model;
        $this->departmentModel = $department_model;
    }

    public function employees(){
        $employees = $this->employeeModel->getListEmployees();
        return view('root.employees.index', [
            'employees' => $employees
        ]);
    }

    public function departments(){
        $departments = $this->departmentModel->getListDepartments();
        return view('root.departments.index', [
            'departments' => $departments
        ]);
    }

    public function requests(){
        return view('root.requests.index');
    }

    public function createEmployee(){
        return 'Đây là trang thêm nhân viên';
    }

    public function updateEmployee(){
        return 'Đây là trang sửa nhân viên';
    }

    public function createDepartment(){
        $managers = $this->employeeModel->getEmployeesIsManager();
        return view('root.departments.create', [
            'managers' => $managers
        ]);
    }

    public function getCreateDepartment(CreateDepartmentRequest $request){
        dd($request);
    }

    public function updateDepartment(){
        return 'Đây là trang sửa phòng ban';
    }
}
