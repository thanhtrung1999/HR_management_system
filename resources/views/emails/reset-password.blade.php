<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="{{asset('')}}">
    <title>Đổi mật khẩu</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="css/_all-skins.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="form-reset-password">
    <h2 class="text-center mb-4">Đổi mật khẩu</h2>
    @if(session()->has('error'))
        <div class="alert alert-danger m-2">
            <h5 style="margin: 0">{{session('error')}}</h5>
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success m-2">
            <h5 style="margin: 0">{{session('success')}}</h5>
        </div>
    @endif
    <form action="{{route('user.resetPassword', ['id' => $id, 'token' => $token])}}" method="post">
        @csrf
        <div class="form-group">
            <label for="current-password">Mật khẩu hiện tại</label>
            <input type="password" id="current-password" name="current_password" class="form-control" placeholder="Current Password">
            @if($errors->has('current_password'))
                <div class="alert alert-danger">
                    <strong>{{$errors->first('current_password')}}</strong>
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="new-password">Mật khẩu mới</label>
            <input type="password" id="new-password" name="new_password" class="form-control" placeholder="New Password">
            @if($errors->has('new_password'))
                <div class="alert alert-danger">
                    <strong>{{$errors->first('new_password')}}</strong>
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="confirm-password">Xác nhận mật khẩu mới</label>
            <input type="password" id="confirm-password" name="confirm_password" class="form-control" placeholder="Confirm Password">
            @if($errors->has('confirm_password'))
                <div class="alert alert-danger">
                    <strong>{{$errors->first('confirm_password')}}</strong>
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="js/jquery-ui.min.js"></script>
<!-- Font Awesome 6 -->
<script src="https://kit.fontawesome.com/5efd05f2e8.js" crossorigin="anonymous"></script>
<!-- Bootstrap 4 -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
{{--<!--CKEditor -->
<script src="ckeditor/ckeditor.js"></script>--}}
<!--My SCRIPT-->
<script src="js/script.js"></script>
<!--<script src="js/sort.js"></script>-->
<!-- page script -->
</body>
</html>
