<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Authenticatable
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
        return Employee::all();
    }

    public function getEmployeesIsManager()
    {
        return Employee::where('user_type', '=', '1')->get();
    }
}
