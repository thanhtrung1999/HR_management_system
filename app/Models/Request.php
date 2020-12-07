<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Request extends Model
{
    use HasFactory;

    protected $table = "requests";

    protected $fillable = [
        'employee_id',
        'start_at',
        'end_at',
        'content',
    ];

    public function employees(){
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }

    public function getRequestsByEmployeeId($employeeId)
    {
        return Request::where('employee_id', $employeeId)->get();
    }

    public function createRequest($request)
    {
        $requestModel = new Request();
        $data = $request->validated();
        $data['employee_id'] = $request->employee_id;
        $requestModel->fill($data);
        $requestModel->save();

        if ($requestModel->id){
            $request = $this->getRequestsById($requestModel->id);
            $created_at = $request->created_at;
            $employeeName = auth('employees')->user()->first_name . ' ' . auth('employees')->user()->last_name;
            $employeePosition = auth('employees')->user()->position;
            $employeeDepartment = auth('employees')->user()->employeeOfDepartment->name;
            $employeeEmail = auth('employees')->user()->email;

            $rootModel = new Root();
            $root = $rootModel->getRoot();
            $emailRoot = $root->email;
            $emailManager = (empty(auth('employees')->user()->employeeOfDepartment->manager)) ? '' : auth('employees')->user()->employeeOfDepartment->manager->email;
            $urlRoot = route('root.getListRequests');
            $urlManager = route('manager.getListRequests');

            $data = [
                'employee_name' => $employeeName,
                'employee_position' => $employeePosition,
                'employee_department' => $employeeDepartment,
                'employee_email' => $employeeEmail,
                'email_root' => $emailRoot,
                'email_manager' => $emailManager,
                'created_at' => $created_at,
                'url_root' => $urlRoot,
                'url_manager' => $urlManager
            ];
            dispatch(new \App\Jobs\SendEmailRequestOfEmployee($data));
        }
    }

    public function deleteRequest($id){
        return Request::destroy($id);
    }

    public function getListRequests()
    {
        return Request::paginate(10);
    }

    public function getRequestsById($id)
    {
        return Request::findOrFail($id);
    }

    public function getListRequestsByManagerId($managerId)
    {
        return DB::table('employees')
            ->join('requests', 'employees.id', '=', 'requests.employee_id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->select("requests.*", "employees.first_name", "employees.last_name", "employees.email", "employees.position", "departments.id AS department_id", "departments.name AS department_name")
            ->where('departments.employee_id', '=', $managerId)
            ->get();
    }

    public function getApprovedRequest($employeeId)
    {
        return Request::where([
            'employee_id' => $employeeId,
            'status' => 1
        ])->get();
    }
}
