<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Employee extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = 'employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function employeeOfDepartment(){
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }

    public function departmentManagedEmployee(){
        return $this->hasOne('App\Models\Department', 'employee_id', 'id');
    }

    public function getListEmployees(){
        return Employee::paginate(10);
    }

    public function getEmployeesIsManager()
    {
        return Employee::where('user_type', '=', 1)->get();
    }

    public function addNewEmployee($request)
    {
        $employee_model = new Employee();
        $employee_model->first_name = $request['first_name'];
        $employee_model->last_name = $request['last_name'];
        $employee_model->email = $request['email'];
        $employee_model->password = Hash::make($request['password']);
        $employee_model->position = $request['position'];
        $employee_model->department_id = $request['department_id'];
        $employee_model->gender = $request['gender'];
        $employee_model->user_type = $request['level'];
        $employee_model->save();
    }

    public function getEmployeeById($id)
    {
        return Employee::find($id);
    }

    public function editEmployee($request, $id)
    {
        $employee = $this->getEmployeeById($id);
        $employee->first_name = $request['first_name'];
        $employee->last_name = $request['last_name'];
        $employee->email = $request['email'];
        if(!empty($request['password'])){
            $employee->password = Hash::make($request['password']);
        }
        $employee->position = $request['position'];
        $employee->department_id = $request['department_id'];
        $employee->gender = $request['gender'];
        $employee->user_type = $request['level'];
        $employee->save();
    }

    public function deleteEmployee($id)
    {
        return Employee::where('id', $id)->delete();
    }
}
