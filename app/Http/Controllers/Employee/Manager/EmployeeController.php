<?php

namespace App\Http\Controllers\Employee\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function getEmployees(){
        $managerId = auth('employees')->user()->id;
        $department = $this->departmentModel->getDepartmentByManagerId($managerId);
        $employees = $this->employeeModel->getListEmployeesByDepartmentId($department->id);
        return view('employees.managers.employees.index', [
            'employees' => $employees
        ]);
    }

    public function detailEmployee($id){
        $employee = $this->employeeModel->getEmployeeById($id);
        return view('employees.managers.employees.detail', [
            'employee' => $employee
        ]);
    }
}
