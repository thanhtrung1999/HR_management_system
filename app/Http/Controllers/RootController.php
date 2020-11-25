<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Root;
use App\Models\Employee;
use App\Models\Department;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\EditEmployeeRequest;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\EditDepartmentRequest;

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
        $departments = $this->departmentModel->getListDepartments();
        return view('root.employees.create', [
            'departments' => $departments
        ]);
    }

    public function postCreateEmployee(CreateEmployeeRequest $request){
        $this->employeeModel->addNewEmployee($request);
        return redirect('root/employees')->with('success', 'Thêm nhân viên thành công');
    }

    public function updateEmployee($id){
        $departments = $this->departmentModel->getListDepartments();
        $employee = $this->employeeModel->getEmployeeById($id);
        return view('root.employees.update', [
            'departments' => $departments,
            'employee' => $employee
        ]);
    }

    public function postUpdateEmployee(EditEmployeeRequest $request, $id){
        $this->employeeModel->editEmployee($request, $id);
        return redirect('root/employees')->with('success', 'Sửa nhân viên thành công');
    }

    public function deleteEmployee($id){
        $this->employeeModel->deleteEmployee($id);
        return redirect()->back()->with('success', 'Xóa nhân viên thành công');
    }

    public function createDepartment(){
        $managers = $this->employeeModel->getEmployeesIsManager();
        return view('root.departments.create', [
            'managers' => $managers
        ]);
    }

    public function getCreateDepartment(CreateDepartmentRequest $request){
        $manager_id = $request->manager;
        $checkManagerManagedDepartment = $this->departmentModel->checkManagerManagedDepartment($manager_id);
        if($checkManagerManagedDepartment === 0){
            $this->departmentModel->addNewDepartment($request);
            return redirect('root/departments')->with('success', 'Thêm phòng ban thành công');
        } else {
            session()->flash('error', 'Trưởng phòng này đã quản lý 1 phòng ban');
            return redirect()->back();
        }
    }

    public function updateDepartment($id){
        $department = $this->departmentModel->getDepartmentById($id);
        $managers = $this->employeeModel->getEmployeesIsManager();
        return view('root.departments.update', [
            'department' => $department,
            'managers' => $managers
        ]);
    }

    public function postUpdateDepartment(EditDepartmentRequest $request, $id){
        $checkManagerManagedDepartment = $this->departmentModel->checkManagerManagedDepartmentExceptMyself($request);
        if($checkManagerManagedDepartment === 0){
            $this->departmentModel->editDepartment($request);
            return redirect('root/departments')->with('success', 'Sửa phòng ban thành công');
        } else {
            session()->flash('error', 'Trưởng phòng này đã quản lý 1 phòng ban');
            return redirect()->back();
        }
    }

    public function deleteDepartment($id){
        $this->departmentModel->deleteDepartment($id);
        return redirect()->back()->with('success', 'Xóa phòng ban thành công');
    }
}
