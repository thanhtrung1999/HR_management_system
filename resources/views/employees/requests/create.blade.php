@extends('layout.master')
@section('title', 'Danh sách yêu cầu')
@section('stylesheet')
{{--    <link rel="stylesheet" href="{{asset('css/jquery.datetimepicker.css')}}">--}}
    <link rel="stylesheet" href="{{asset('css/css-loader.css')}}">
@endsection
@section('active-link-requests', 'active')
@section('breadcrumb')
    <a href="{{route('employee.listRequests')}}" class="pr-2 nav-link d-inline-block">Danh sách yêu cầu</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{route('employee.createRequest')}}" class="pl-2 nav-link d-inline-block">Tạo yêu cầu</a>
@endsection
@section('content')
    <create-request-component
        :employee="{{ auth('employees')->user() }}"
        :employeeOfDepartment="{{ auth('employees')->user()->employeeOfDepartment }}"
        :manager="{{ auth('employees')->user()->employeeOfDepartment->manager }}">
    </create-request-component>
{{--    <div class="create-request-container">--}}
{{--        <h4>New Request</h4>--}}
{{--        <div class="row form-create">--}}
{{--            <form action="{{route('employee.postCreateRequest')}}" class="col-md-5" method="post">--}}
{{--                @csrf--}}
{{--                <div class="form-group">--}}
{{--                    <label for="content">Nội dung (Lý do xin nghỉ)</label>--}}
{{--                    <textarea name="content" id="content" rows="6" class="form-control" style="resize: vertical"></textarea>--}}
{{--                    @if($errors->has('content'))--}}
{{--                        <div class="alert alert-danger">--}}
{{--                            <strong>{{$errors->first('content')}}</strong>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    <div class="form-group col-md-6">--}}
{{--                        <label for="start-at">Start at</label>--}}
{{--                        <input type="text" class="form-control" id="start-at" name="start_at">--}}
{{--                        @if($errors->has('start_at'))--}}
{{--                            <div class="alert alert-danger">--}}
{{--                                <strong>{{$errors->first('start_at')}}</strong>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    <div class="form-group col-md-6">--}}
{{--                        <label for="end-at">End at</label>--}}
{{--                        <input type="text" class="form-control" id="end-at" name="end_at">--}}
{{--                        @if($errors->has('end_at'))--}}
{{--                            <div class="alert alert-danger">--}}
{{--                                <strong>{{$errors->first('end_at')}}</strong>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <input type="hidden" name="employee_id" value="{{auth('employees')->user()->id}}">--}}
{{--                <div class="form-group">--}}
{{--                    <input type="submit" name="submit" class="btn btn-primary" value="Save">--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
{{--@section('script')
    <script src="{{asset('js/build/jquery.datetimepicker.full.min.js')}}"></script>
    <script type="text/javascript">
        $('#start-at').datetimepicker({
            format:'Y-m-d H:i',
            minDate: new Date()
        });
        $('#end-at').datetimepicker({
            format:'Y-m-d H:i',
            minDate: new Date()
        });
    </script>
@endsection--}}
