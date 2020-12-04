@extends('layout.master')
@section('title', 'Yêu cầu cần duyệt')
@section('breadcrumb')
    <a href="{{route('root.getListRequests')}}" class="nav-link">Yêu cầu cần duyệt</a>
@endsection
@section('active-link-requests', 'active')
@section('content')
    <h2>Danh sách yêu cầu</h2>
    <div class="table-content mt-4">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>STT</th>
                <th>Tên nhân viên</th>
                <th>Email</th>
                <th>Phòng ban</th>
                <th>Nội dung (Lý do xin nghỉ)</th>
                <th>Start at</th>
                <th>End at</th>
                <th>Trạng thái</th>
                <th>Xác nhận bởi</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật gần nhất</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if($requests->isNotEmpty())
                @foreach($requests as $index => $request)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$request->employees->first_name}} {{$request->employees->last_name}}</td>
                        <td>{{$request->employees->email}}</td>
                        <td>{{$request->employees->employeeOfDepartment->name}}</td>
                        <td>{{$request->content}}</td>
                        <td>{{$request->start_at}}</td>
                        <td>{{$request->end_at}}</td>
                        <td>
                            @if($request->status == 0)
                                Chưa duyệt
                            @elseif($request->status == 1)
                                Đã duyệt
                            @elseif($request->status == 2)
                                Đã hủy
                            @endif
                        </td>
                        <td>
                            @if(!empty($request->approval_by))
                                @if($request->approval_by == 1)
                                    Trưởng phòng
                                @else
                                    Root
                                @endif
                            @endif
                        </td>
                        <td>{{$request->created_at}}</td>
                        <td>{{$request->updated_at}}</td>
                        <td>
                            @if(empty($request->status) || $request->status == 0)
                                <a onclick="return confirm('Bạn có chắc chắn muốn duyệt yêu cầu không?')" href="{{route('root.approvalRequest', ['id'=>$request->id])}}" class="btn btn-outline-success mt-1 mr-2">Duyệt</a>
                                <a onclick="return confirm('Bạn có chắc chắn muốn hủy yêu cầu không?')" href="{{route('root.cancelRequest', ['id'=>$request->id])}}" class="btn btn-danger mt-1">Hủy</a>
                            @else
                                @if($request->status == 1)
                                    <p>Yêu cầu đã được duyệt</p>
                                @elseif($request->status == 2)
                                    <p>Yêu cầu đã bị hủy</p>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9"><h3 class="text-center p-4">Không có dữ liệu</h3></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
