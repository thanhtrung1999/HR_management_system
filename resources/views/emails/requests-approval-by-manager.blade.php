<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="{{asset('')}}">
    <title>Xác thực yêu cầu nghỉ phép của nhân viên</title>
</head>
<body>
<h1>Xác nhận yêu cầu nghỉ phép</h1>
<h3>
    <p>Nhân viên {{$employee_name}}({{$employee_position}}) đã tạo yêu cầu nghỉ nghỉ phép vào ngày {{$created_at}}.</p>
    <p>Truy cập vào đường dẫn <a href="{{$url_manager}}">tại đây</a> để xác nhận yêu cầu</p>
</h3>
</body>
</html>
