@extends('layout.master')
@section('title', 'Danh sách yêu cầu')
@section('active-link-requests', 'active')
@section('breadcrumb')
    <a href="{{route('employee.listRequests')}}" class="pr-2 nav-link d-inline-block">Danh sách yêu cầu</a>
@endsection
@section('content')
    <h2>Danh sách yêu cầu</h2>
    <a href="{{route('employee.createRequest')}}" class="btn btn-success">+ New Request</a>
    <div class="table-content mt-4">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Nội dung (Lý do xin nghỉ)</th>
                    <th>Start at</th>
                    <th>End at</th>
                    <th>Trạng thái</th>
                    <th>Xác nhận bởi</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật gần nhất</th>
                    @if($requests->isNotEmpty())
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if($requests->isNotEmpty())
                    @foreach($requests as $index => $request)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$request->content}}</td>
                            <td>{{$request->start_at}}</td>
                            <td>{{$request->end_at}}</td>
                            <td>
                                @if($request->status == 0)
                                    Chưa duyệt
                                @elseif($request->status == 1)
                                    Yêu cầu đã được duyệt
                                @elseif($request->status == 2)
                                    Yêu cầu đã bị hủy
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
                                @if($request->status == 0)
                                    <form action="{{route('employee.cancelRequest', ['request' => $request->id])}}" method="post" class="form-btn-delete">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn-delete-record" title="Cancel" onclick="return confirm('Bạn có chắc chắn muốn hủy yêu cầu không?')"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8"><h3 class="text-center p-4">Không có dữ liệu</h3></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
