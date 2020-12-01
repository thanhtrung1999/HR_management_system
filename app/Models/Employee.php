<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;

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

    public function workingDays(){
        return $this->hasMany('App\Models\WorkingDays', 'employee_id', 'id');
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
        $password = Str::random(8);
        $employeeModel = new Employee();
        $employeeModel->first_name = $request['first_name'];
        $employeeModel->last_name = $request['last_name'];
        $employeeModel->email = $request['email'];
        $employeeModel->password = Hash::make($password);
        $employeeModel->position = $request['position'];
        $employeeModel->department_id = $request['department_id'];
        $employeeModel->gender = $request['gender'];
        $employeeModel->user_type = $request['level'];
        $token = md5((string) Str::uuid());
        $employeeModel->email_verify_token = $token;
        $employeeModel->save();

        if ($employeeModel->id){
            $data = [
                'email' => $request['email'],
                'password' => $password,
                'url' => \route('user.verify', ['id'=>$employeeModel->id,'token'=>$token]),
            ];
            dispatch(new \App\Jobs\SendAccountVerificationEmail($data));
        }
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

    public function getEmployeeByToken($token)
    {
        return Employee::where('email_verify_token', $token)->first();
    }
}
