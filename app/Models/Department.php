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
}
