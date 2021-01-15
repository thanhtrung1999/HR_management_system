<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <base href="{{asset('')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <!--    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">-->
    <!-- JQuery UI -->
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.theme.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <!-- My CSS -->
    @yield('stylesheet')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('layout.header')
    @include('layout.sidebar')
    <div class="content-wrapper">
        @if(session()->has('error'))
            <div class="alert alert-danger m-2 d-inline-block">
                <h5 style="margin: 0">{{session('error')}}</h5>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success m-2 d-inline-block">
                <h5 style="margin: 0">{{session('success')}}</h5>
            </div>
        @endif

        <!-- Main content -->
        <section class="content">
            <div id="app" class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    @include('layout.footer')
    <!-- control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="/js/app.js"></script>
{{--<!-- jQuery -->--}}
{{--<script src="{{asset('js/jquery.min.js')}}"></script>--}}
{{--<!-- jQuery UI 1.12.1 --> --}}
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<!-- Font Awesome 6 -->
<script src="https://kit.fontawesome.com/5efd05f2e8.js" crossorigin="anonymous"></script>
{{--<!-- Bootstrap 4 -->--}}
{{--<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>--}}
{{--<!-- Bootstrap 3.3.7 -->--}}
{{--<script src="{{asset('js/bootstrap.min.js')}}"></script>--}}
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
{{--<!--CKEditor -->
<script src="ckeditor/ckeditor.js"></script>--}}
<!--My SCRIPT-->
@yield('script')
{{--<script src="{{asset('js/script.js')}}"></script>--}}
<script type="text/javascript">
    $('.table-content table.table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });
</script>
</body>
</html>
