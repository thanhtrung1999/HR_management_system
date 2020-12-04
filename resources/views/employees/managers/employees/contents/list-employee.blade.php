<div class="table-content mt-4">
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Chức vụ</th>
            <th>Số điện thoại</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if($employees->isNotEmpty())
            @foreach($employees as $employee)
                <tr>
                    <th>{{$employee->id}}</th>
                    <td>{{$employee->first_name}} {{$employee->last_name}}</td>
                    <td>{{$employee->email}}</td>
                    <td>{{$employee->position}}</td>
                    <td>{{$employee->phone_number}}</td>
                    <td><a href="{{route('manager.detailEmployee', ['id'=>$employee->id])}}"><i class="fas fa-eye"></i></a></td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
