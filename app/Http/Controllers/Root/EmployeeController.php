<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\EditEmployeeRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
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
     * @return Application|Factory|View
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
     * @return Application|RedirectResponse|Redirector
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
     * @return Application|Factory|View
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
     * @return Application|RedirectResponse|Redirector
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
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->employeeModel->deleteEmployee($id);
        return redirect()->back()->with('success', 'Xóa nhân viên thành công');
    }
}
