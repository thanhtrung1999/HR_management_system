@extends('layout.master')
@section('title', 'Quản lý nhân viên')
@section('breadcrumb')
    <a href="{{route('employees.index')}}" class="nav-link">Quản lý nhân viên</a>
@endsection
@section('active-link-employees', 'active')
@section('content')
    <form action="reset-password" method="post">
        @csrf
        <h2>Danh sách nhân viên</h2>
        <a href="{{route('employees.create')}}" class="btn btn-success">+ New Employee</a>
        <button type="submit" name="rpass" class="btn btn-outline-danger ml-2">Reset Password</button>
        <div class="table-content mt-4">
            <form action="" method="post"></form>
            <table id="employees-table--root" class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th style="width: 8%;">Reset Password</th>
                    <th style="width: 2%;" scope="col">ID</th>
                    <th style="width: 10%;" scope="col">Họ và tên</th>
                    <th style="width: 8%" scope="col">Email</th>
                    <th style="width: 7%" scope="col">Chức vụ (Vị trí)</th>
                    <th style="width: 7%" scope="col">Phòng ban (Bộ phận)</th>
                    <th style="width: 7%" scope="col">Avatar</th>
                    <th style="width: 6%" scope="col">Giới tính</th>
                    <th style="width: 7%" scope="col">Số điện thoại</th>
                    <th style="width: 7%" scope="col">Địa chỉ</th>
                    <th style="width: 7%" scope="col">Cấp độ</th>
                    <th style="width: 8%" scope="col">Ngày tạo</th>
                    <th style="width: 8%" scope="col">Ngày cập nhật gần nhất</th>
                    <th style="width: 8%" scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @if($employees->isNotEmpty())
                    @foreach($employees as $employee)
                        <tr>
                            <th><input type="checkbox" name="reset_password[]" value="{{$employee->id}}"></th>
                            <th scope="row">{{$employee->id}}</th>
                            <td>{{$employee->first_name}} {{$employee->last_name}}</td>
                            <td>{{$employee->email}}</td>
                            <td>{{$employee->position}}</td>
                            <td>@php echo !empty($employee->employeeOfDepartment) ? $employee->employeeOfDepartment->name : '' @endphp</td>
                            <td><img style="width: 5rem" src="images/uploads/{{$employee->avatar}}" alt=""></td>
                            @if($employee->gender == 1)
                                <td>Nam</td>
                            @else
                                <td>Nữ</td>
                            @endif
                            <td>{{$employee->phone_number}}</td>
                            <td>{{$employee->address}}</td>
                            @if($employee->user_type == 0)
                                <td>Nhân viên</td>
                            @else
                                <td>Trưởng phòng</td>
                            @endif
                            <td>{{$employee->created_at}}</td>
                            <td>{{$employee->updated_at}}</td>
                            <td>
                                <a title="Update" href="{{route('employees.edit', ['employee'=>$employee->id])}}"><i class="fa fa-pencil-alt"></i></a> &nbsp;&nbsp;
                                <form class="form-btn-delete" action="{{route('employees.destroy', ['employee'=>$employee->id])}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn-delete-record" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')"><i
                                            class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            {{--<div align='right'>
                {!! $employees->links() !!}
            </div>--}}
        </div>
    </form>
@endsection
@section('script')
    <script type="text/javascript">
        $('#employees-table--root').DataTable({
            "ordering": false,
        });
    </script>
@endsection
