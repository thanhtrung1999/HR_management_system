<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\EditDepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateDepartmentRequest $request)
    {
        $managerId = $request->manager;
        $hasManagedDepartment = $this->departmentModel->checkManagerManagedDepartment($managerId);
        if($hasManagedDepartment){
            return redirect()->back()->with('error', 'Trưởng phòng này đã quản lý 1 phòng ban');
        }
        $this->departmentModel->addNewDepartment($request);
        return redirect()->route('departments.index')->with('success', 'Thêm phòng ban thành công');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EditDepartmentRequest $request, $id)
    {
        $hasManagedDepartment = $this->departmentModel->checkManagerManagedDepartmentExceptMyself($request);
        if($hasManagedDepartment){
            return redirect()->back()->with('error', 'Trưởng phòng này đã quản lý 1 phòng ban');
        }
        $this->departmentModel->editDepartment($request, $id);
        return redirect()->route('departments.index')->with('success', 'Sửa phòng ban thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->departmentModel->deleteDepartment($id);
        return redirect()->back()->with('success', 'Xóa phòng ban thành công');
    }
}
