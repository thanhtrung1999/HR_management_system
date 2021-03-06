<?php

namespace App\Models;

use App\Jobs\SendAccountVerificationEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use function route;

class Employee extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = 'employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'position',
        'department_id'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    private const USERTYPE_EMPLOYEE = 0;
    private const USERTYPE_MANAGER = 1;

    public function employeeOfDepartment()
    {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }

    public function departmentManagedEmployee()
    {
        return $this->hasOne('App\Models\Department', 'employee_id', 'id');
    }

    public function workingDays()
    {
        return $this->hasMany('App\Models\WorkingDays', 'employee_id', 'id');
    }

    public function getListEmployees()
    {
        return Employee::all();
    }

    public function getEmployeesIsManager()
    {
        return Employee::where('user_type', '=', self::USERTYPE_MANAGER)->get();
    }

    public function addNewEmployee($request)
    {
        $password = Str::random(8);
        $token = md5((string) Str::uuid());
        $data = $request->validated();
        $data['password'] = $password;

        $employeeModel = new Employee();
        $employeeModel->fill($data);
        $employeeModel->email_verify_token = $token;
        $employeeModel->save();

        if ($employeeModel->id) {
            $data = [
                'email' => $request['email'],
                'password' => $password,
                'url' => route('user.verify', ['id'=>$employeeModel->id,'token'=>$token]),
            ];
            dispatch(new SendAccountVerificationEmail($data));
        }
    }

    public function getEmployeeById($id)
    {
        return Employee::find($id);
    }

    public function editEmployee($request, $id)
    {
        $employee = $this->getEmployeeById($id);
        $employee->first_name = $request['first_name'];
        $employee->last_name = $request['last_name'];
        $employee->email = $request['email'];
        if (!empty($request['password'])) {
            $employee->password = Hash::make($request['password']);
        }
        $employee->position = $request['position'];
        $employee->department_id = $request['department_id'];
        $employee->gender = $request['gender'];
        $employee->user_type = $request['level'];
        $employee->save();
    }

    public function deleteEmployee($id)
    {
        return Employee::where('id', $id)->delete();
    }

    public function getEmployeeByToken($token)
    {
        return Employee::where('email_verify_token', $token)->first();
    }

    public function editProfile($request, $id)
    {
        $profile = $this->getEmployeeById($id);
        $profile->first_name = $request['first_name'];
        $profile->last_name = $request['last_name'];
        if ($request->has('profile_img')) {
            if (!file_exists('images/uploads')) {
                mkdir('images/uploads');
            }
            if (!empty($profile->avatar)) {
                unlink('images/uploads/'.$profile->avatar);
            }
            $file = $request['profile_img'];
            $file_name = time() . '-profile-'. $id .'-' . $_FILES['profile_img']['name'];
            $file->move('images/uploads/', $file_name);
            $profile->avatar = $file_name;
        }
        $profile->gender = $request['gender'];
        $profile->birthday = $request['birthday'];
        $profile->phone_number = $request['phone'];
        $profile->address = $request['address'];
        $profile->save();
    }

    public function getListEmployeesByDepartmentId($departmentId)
    {
        return Employee::where('department_id', $departmentId)->get();
    }
}
