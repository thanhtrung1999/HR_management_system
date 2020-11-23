<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RootController extends Controller
{
    public function employees(){
        return view('root.employees.index');
    }

    public function departments(){
        return view('root.departments.index');
    }

    public function requests(){
        return view('root.requests.index');
    }

    public function createEmployee(){
        return 'Đây là trang tạo nhân viên';
    }

    public function updateEmployee(){
        return 'Đây là trang sửa nhân viên';
    }

    public function createDepartment(){
        return 'Đây là trang tạo phòng ban';
    }

    public function updateDepartment(){
        return 'Đây là trang sửa phòng ban';
    }
}
