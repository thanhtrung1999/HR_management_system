<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Models\Root;
use App\Models\Employee;
use App\Models\Department;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\EditEmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * @var Root
     */
    private $rootModel;
    /**
     * @var Employee
     */
    private $employeeModel;
    /**
     * @var Department
     */
    private $departmentModel;

    /**
     * EmployeeController constructor.
     * @param Root $root_model
     * @param Employee $employee_model
     * @param Department $department_model
     */
    public function __construct(Root $root_model, Employee $employee_model, Department $department_model)
    {
        $this->rootModel = $root_model;
        $this->employeeModel = $employee_model;
        $this->departmentModel = $department_model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $employees = $this->employeeModel->getListEmployees();
        return view('root.employees.index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $departments = $this->departmentModel->getListDepartments();
        return view('root.employees.create', [
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateEmployeeRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateEmployeeRequest $request)
    {
        $this->employeeModel->addNewEmployee($request);
        return redirect()->route('employees.index')->with('success', 'Thêm nhân viên thành công');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $departments = $this->departmentModel->getListDepartments();
        $employee = $this->employeeModel->getEmployeeById($id);
        return view('root.employees.update', [
            'departments' => $departments,
            'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditEmployeeRequest $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EditEmployeeRequest $request, $id)
    {
        $this->employeeModel->editEmployee($request, $id);
        return redirect()->route('employees.index')->with('success', 'Sửa nhân viên thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->employeeModel->deleteEmployee($id);
        return redirect()->back()->with('success', 'Xóa nhân viên thành công');
    }
}
