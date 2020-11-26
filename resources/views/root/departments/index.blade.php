@extends('layout.master')
@section('title', 'Quản lý phòng ban')
@section('breadcrumb')
    <a href="{{route('departments.index')}}" class="nav-link">Quản lý phòng ban</a>
@endsection
@section('active-link-departments', 'active')
@section('content')
    <h2>Danh sách phòng ban</h2>
    <a href="{{route('departments.create')}}" class="btn btn-success">+ New Department</a>
    <div class="table-content mt-4">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên phòng ban</th>
                    <th scope="col">Trưởng phòng</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Ngày cập nhật gần nhất</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($departments))
                @foreach($departments as $department)
                    <tr>
                        <th scope="row">{{$department->id}}</th>
                        <td>{{$department->name}}</td>
                        <td>@php echo !empty($department->manager) ? $department->manager->first_name . ' ' . $department->manager->last_name : '' @endphp</td>
                        <td>{{$department->created_at}}</td>
                        <td>{{$department->updated_at}}</td>
                        <td>
                            <a title="Update" href="{{route('departments.edit', ['department'=>$department->id])}}"><i class="fa fa-pencil-alt"></i></a> &nbsp;&nbsp;
                            <form class="form-btn-delete" action="{{route('departments.destroy', ['department'=>$department->id])}}">
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
    </div>
@endsection
