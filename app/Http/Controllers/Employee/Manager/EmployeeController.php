<?php

namespace App\Http\Controllers\Employee\Manager;

use App\Http\Controllers\Controller;
use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function exportEmployee(){
        return Excel::download(new EmployeeExport(), 'employees.xlsx');
    }
}
