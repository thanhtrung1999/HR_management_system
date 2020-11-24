@extends('login.master')
@section('content')
<p class="login-box-msg">Sign in to start your session</p>
@if(session()->has('success'))
    <div class="alert alert-success">
        <strong>{{session('success')}}</strong>
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger">
        <strong>{{session('error')}}</strong>
    </div>
@endif
<form method="post" action="">
    @csrf
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" value="{{old('email')}}" id="email" class="form-control"/>
        @if($errors->has('email'))
            <div class="alert alert-danger">
                <strong>{{$errors->first('email')}}</strong>
            </div>
        @endif
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" value="" id="password" class="form-control"/>
        @if($errors->has('password'))
            <div class="alert alert-danger">
                <strong>{{$errors->first('password')}}</strong>
            </div>
        @endif
    </div>
    <div class="form-group">
        <label for="type">Đăng nhập với tư cách:</label>
        <input type="radio" name="type" value="root" id="root"> Root
        <input type="radio" name="type" value="employee" id="employee"> Nhân viên
        @if($errors->has('type'))
            <div class="alert alert-danger">
                <strong>{{$errors->first('type')}}</strong>
            </div>
        @endif
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Đăng nhập" class="btn btn-primary"/>
    </div>
</form>
@endsection
