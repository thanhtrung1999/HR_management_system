<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departments';

    public function employees(){
        return $this->hasMany('App\Models\Employee', 'department_id', 'id');
    }

    public function manager(){
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }

    public function getListDepartments()
    {
        return Department::all();
    }

    public function checkManagerManagedDepartment($managerId)
    {
        return Department::where('employee_id', '=', $managerId)->count();
    }

    public function addNewDepartment($request)
    {
        $departmentModel = new Department();
        $departmentModel->name = $request->department_name;
        $departmentModel->employee_id = $request->manager;
        $departmentModel->save();
    }

    public function getDepartmentById($id)
    {
        return Department::find($id);
    }

    public function checkManagerManagedDepartmentExceptMyself($request)
    {
        return Department::where([
            ['employee_id', '=', $request->manager],
            ['id', '<>', $request->department_id]
        ])->count();
    }

    public function editDepartment($request, $id)
    {
        $department = $this->getDepartmentById($id);
        $department->name = $request->department_name;
        $department->employee_id = $request->manager;
        $department->save();
    }

    public function deleteDepartment($id)
    {
        return Department::where('id', $id)->delete();
    }
}
