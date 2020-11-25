<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

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

    public function checkManagerManagedDepartment($manager_id)
    {
        return Department::where('employee_id', '=', $manager_id)->count();
    }

    public function addNewDepartment($request)
    {
        $department_model = new Department();
        $department_model->name = $request->department_name;
        $department_model->employee_id = $request->manager;
        $department_model->save();
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

    public function editDepartment($request)
    {
        $department = $this->getDepartmentById($request->department_id);
        $department->name = $request->department_name;
        $department->employee_id = $request->manager;
        $department->save();
    }

    public function deleteDepartment($id)
    {
        return Department::destroy($id);
    }
}
