<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\EditDepartmentRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $departments = $this->departmentModel->getListDepartments();
        return view('root.departments.index', [
            'departments' => $departments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $managers = $this->employeeModel->getEmployeesIsManager();
        return view('root.departments.create', [
            'managers' => $managers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateDepartmentRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateDepartmentRequest $request)
    {
        $managerId = $request->manager;
        $hasManagedDepartment = $this->departmentModel->checkManagerManagedDepartment($managerId);
        if ($hasManagedDepartment) {
            return redirect()->back()->with('error', 'Trưởng phòng này đã quản lý 1 phòng ban');
        }
        $this->departmentModel->addNewDepartment($request);
        return redirect()->route('departments.index')->with('success', 'Thêm phòng ban thành công');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $department = $this->departmentModel->getDepartmentById($id);
        $managers = $this->employeeModel->getEmployeesIsManager();
        return view('root.departments.update', [
            'department' => $department,
            'managers' => $managers
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditDepartmentRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(EditDepartmentRequest $request, $id)
    {
        $hasManagedDepartment = $this->departmentModel->checkManagerManagedDepartmentExceptMyself($request);
        if ($hasManagedDepartment) {
            return redirect()->back()->with('error', 'Trưởng phòng này đã quản lý 1 phòng ban');
        }
        $this->departmentModel->editDepartment($request, $id);
        return redirect()->route('departments.index')->with('success', 'Sửa phòng ban thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->departmentModel->deleteDepartment($id);
        return redirect()->back()->with('success', 'Xóa phòng ban thành công');
    }
}
