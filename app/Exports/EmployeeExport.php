<?php

namespace App\Exports;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        $departmentModel = new Department();
        $employeeModel = new Employee();

        $managerId = auth('employees')->user()->id;
        $department = $departmentModel->getDepartmentByManagerId($managerId);
        $employees = $employeeModel->getListEmployeesByDepartmentId($department->id);
        return view('employees.managers.employees.contents.list-employee', [
            'employees' => $employees
        ]);
    }
}
