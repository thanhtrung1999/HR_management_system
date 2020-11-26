@extends('layout.master')
@section('title', 'Thêm phòng ban')
@section('breadcrumb')
    <a href="{{route('departments.index')}}" class="pr-2 nav-link d-inline-block">Quản lý phòng ban</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{route('departments.create')}}" class="pl-2 nav-link d-inline-block">Thêm phòng ban</a>
@endsection
@section('active-link-departments', 'active')
@section('content')
    <h2>Thêm phòng ban (bộ phận)</h2>
    <div class="form-content row mt-4">
        <form class="col-md-8" action="{{route('departments.store')}}" method="post">
            @csrf
            <div class="form-group">
                <input class="form-control" placeholder="Tên phòng (Bộ phận)" type="text" name="department_name" id="department-name" value="{{old('department_name')}}">
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
                            <option value="{{$manager->id}}">{{$manager->email}} - {{$manager->first_name}} {{$manager->last_name}}</option>
                        @endforeach
                    @endif
                </select>
                @if($errors->has('manager'))
                    <div class="alert alert-danger">
                        <strong>{{$errors->first('manager')}}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Save">
                <input type="reset" name="reset" class="btn btn-secondary" value="Reset">
            </div>
        </form>
    </div>
@endsection
