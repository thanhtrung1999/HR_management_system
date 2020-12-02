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
        <div class="row profile-content">
            <form class="col-md-8" action="{{route('profile.update', ['profile' => auth('employees')->user()->id])}}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="first-name">First name</label>
                        <input type="text" class="form-control" placeholder="First name" name="first_name" id="first-name" value="{{auth('employees')->user()->first_name}}">
                        @if($errors->has('first_name'))
                            <div class="alert alert-danger">
                                <strong>{{$errors->first('first_name')}}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last-name">Last name</label>
                        <input type="text" class="form-control" placeholder="Last name" name="last_name" id="last-name" value="{{auth('employees')->user()->last_name}}">
                        @if($errors->has('last_name'))
                            <div class="alert alert-danger">
                                <strong>{{$errors->first('last_name')}}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="img-file">Avatar</label>
                    <input id="img-file" type="file" name="profile_img" class="form-control hidden"
                           onchange="changeImg(this)">
                    <img id="avatar" class="thumbnail" style="height: 15rem" width="30%" src="{{empty(auth('employees')->user()->avatar) ? 'http://www.clker.com/cliparts/d/L/P/X/z/i/no-image-icon-hi.png' : 'images/uploads/'.auth('employees')->user()->avatar}}">
                    @if($errors->has('profile_img'))
                        <div class="alert alert-danger">
                            <strong>{{$errors->first('profile_img')}}</strong>
                        </div>
                    @endif
                </div>
                @php
                    $checkedMale = '';
                    $checkedFemale = '';
                    if (auth('employees')->user()->gender == 1){
                        $checkedMale = 'checked';
                    } else {
                        $checkedFemale = 'checked';
                    }
                @endphp
                <div class="form-group">
                    <label for="gender">Giới tính</label>
                    <br/>
                    <input {{$checkedMale}} type="radio" name="gender" id="male" value="1"> Nam
                    <input {{$checkedFemale}} type="radio" name="gender" id="female" value="0"> Nữ
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="birthday">Ngày sinh</label>
                        <input type="text" id="birthday" class="form-control" name="birthday" value="{{auth('employees')->user()->birthday}}">
                        @if($errors->has('birthday'))
                            <div class="alert alert-danger">
                                <strong>{{$errors->first('birthday')}}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" placeholder="Phone" name="phone" id="phone" value="{{auth('employees')->user()->phone_number}}">
                    @if($errors->has('phone'))
                        <div class="alert alert-danger">
                            <strong>{{$errors->first('phone')}}</strong>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input type="text" class="form-control" placeholder="Address" name="address" id="address" value="{{auth('employees')->user()->address}}">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Save">
                    <input type="reset" name="reset" class="btn btn-secondary" value="Reset">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>

        function changeImg(input) {
            //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                //Sự kiện file đã được load vào website
                reader.onload = function (e) {
                    //Thay đổi đường dẫn ảnh
                    $('#avatar').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function () {
            $('#avatar').click(function () {
                $('#img-file').click();
            });
            $( "#birthday" ).datepicker({ dateFormat: 'yy-mm-dd' });
        });

    </script>
@endsection
