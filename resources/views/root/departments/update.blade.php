@extends('layout.master')
@section('title', 'Sửa phòng ban')
@section('breadcrumb')
    <a href="{{route('departments.index')}}" class="pr-2 nav-link d-inline-block">Quản lý phòng ban</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{route('departments.edit', ['department'=>$department->id])}}" class="pl-2 nav-link d-inline-block">Sửa phòng ban</a>
@endsection
@section('active-link-departments', 'active')
@section('content')
    <h2>Sửa phòng ban (bộ phận)</h2>
    <div class="form-content mt-4">
        <form action="{{route('departments.update', ['department'=>$department->id])}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input class="form-control" placeholder="Tên phòng ban (Bộ phận)" type="text" name="department_name" id="department-name" value="@if(isset($_POST['submit'])) {{old('department_name')}} @else {{$department->name}} @endif">
                @if($errors->has('department_name'))
                    <div class="alert alert-danger">
                        <strong>{{$errors->first('department_name')}}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <select class="form-control" name="manager" id="manager">
                    <option value="0">--Chọn trưởng phòng--</option>
                    @if(!empty($managers))
                        @foreach($managers as $manager)
                            <option @if($department->employee_id == $manager->id) selected @endif value="{{$manager->id}}">{{$manager->email}} - {{$manager->first_name}} {{$manager->last_name}}</option>
                        @endforeach
                    @endif
                </select>
                @if($errors->has('manager'))
                    <div class="alert alert-danger">
                        <strong>{{$errors->first('manager')}}</strong>
                    </div>
                @endif
            </div>
            <input type="hidden" name="department_id" value="{{$department->id}}">
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Save">
                <input type="reset" name="reset" class="btn btn-secondary" value="Reset">
            </div>
        </form>
    </div>
@endsection
