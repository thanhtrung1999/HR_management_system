@extends('layout.master')
@section('title', 'Profile')
@section('breadcrumb')
    <a href="{{route('profile.index')}}" class="pr-2 nav-link d-inline-block">Profile</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{route('profile.edit', ['profile' => auth('employees')->user()->id])}}" class="pl-2 nav-link d-inline-block">Edit</a>
@endsection
@section('content')
    <div class="profile-wrapper">
        <h4>Edit Profile</h4>
        <div class="profile-content">
            <h2>Đây là trang sửa profile</h2>
        </div>
    </div>
@endsection
