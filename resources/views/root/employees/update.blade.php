@extends('layout.master')
@section('title', 'Sửa nhân viên')
@section('breadcrumb')
    <a href="{{route('employees.index')}}" class="pr-2 nav-link d-inline-block">Quản lý nhân viên</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{route('employees.edit', ['employee'=>$employee->id])}}" class="pl-2 nav-link d-inline-block">Sửa nhân viên</a>
@endsection
@section('active-link-employees', 'active')
@section('content')
    <h2>Sửa nhân viên</h2>
    <div class="form-content row mt-4">
        <form class="col-md-8" action="{{route('employees.update', ['employee'=>$employee->id])}}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="first-name">First name</label>
                    <input type="text" class="form-control" placeholder="First name" name="first_name" id="first-name" value="{{$employee->first_name}}">
                    @if($errors->has('first_name'))
                        <div class="alert alert-danger">
                            <strong>{{$errors->first('first_name')}}</strong>
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="last-name">Last name</label>
                    <input type="text" class="form-control" placeholder="Last name" name="last_name" id="last-name" value="{{$employee->last_name}}">
                    @if($errors->has('last_name'))
                        <div class="alert alert-danger">
                            <strong>{{$errors->first('last_name')}}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="{{$employee->email}}">
                @if($errors->has('email'))
                    <div class="alert alert-danger">
                        <strong>{{$errors->first('email')}}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Password" name="password" id="email" value="">
                @if($errors->has('password'))
                    <div class="alert alert-danger">
                        <strong>{{$errors->first('password')}}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="position">Chức vụ (Vị trí)</label>
                <input type="text" class="form-control" placeholder="Chức vụ" name="position" id="position" value="{{$employee->position}}">
            </div>
            <div class="form-group">
                <label for="department-id">Phòng ban (Bộ phận) làm việc</label>
                <select name="department_id" id="department-id" class="form-control">
                    <option value="0">--Chọn phòng ban--</option>
                    @if(!empty($departments))
                        @foreach($departments as $department)
                            @if(empty($department->manager))
                                <option @if($employee->department_id == $department->id) selected @endif value="{{$department->id}}">{{$department->name}}</option>
                            @else
                                <option @if($employee->department_id == $department->id) selected @endif value="{{$department->id}}">{{$department->name}} - Trưởng phòng: [{{$department->manager->first_name}} {{$department->manager->last_name}} - {{$department->manager->email}}]</option>
                            @endif
                        @endforeach
                    @endif
                </select>
                @if($errors->has('department_id'))
                    <div class="alert alert-danger">
                        <strong>{{$errors->first('department_id')}}</strong>
                    </div>
                @endif
            </div>
            <?php
            $checkedMale = '';
            $checkedFemale = '';
            if ($employee->gender == 1){
                $checkedMale = 'checked';
            } else {
                $checkedFemale = 'checked';
            }
            ?>
            <div class="form-group">
                <label for="gender">Giới tính</label>
                <br/>
                <input {{$checkedMale}} type="radio" name="gender" id="male" value="1"> Nam
                <input {{$checkedFemale}} type="radio" name="gender" id="female" value="0"> Nữ
            </div>
            <?php
            $checkedEmployee = '';
            $checkedManager = '';
            if ($employee->user_type == 0){
                $checkedEmployee = 'checked';
            } else {
                $checkedManager = 'checked';
            }
            ?>
            <div class="form-group">
                <label for="level">Cấp độ</label>
                <br/>
                <input {{$checkedEmployee}} type="radio" name="level" id="employee" value="0"> Nhân viên
                <input {{$checkedManager}} type="radio" name="level" id="manager" value="1"> Trưởng phòng
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Save">
                <input type="reset" name="reset" class="btn btn-secondary" value="Reset">
            </div>
        </form>
    </div>
@endsection
