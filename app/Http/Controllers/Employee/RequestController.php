<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequestRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\RequestCollection;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $employeeId = auth('employees')->user()->id;
        $requests = $this->requestModel->getRequestsByEmployeeId($employeeId);
        return view('employees.requests.index', [
            'requests' => $requests
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('employees.requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeRequestRequest $request
     * @return RedirectResponse
     */
    public function store(EmployeeRequestRequest $request)
    {
        $this->requestModel->createRequest($request);
        return redirect()->route('employee.listRequests')->with('success', 'Tạo yêu cầu thành công');
    }

    public function storeAPI(Request $request)
    {
//        $this->requestModel->createRequestApi($request);
        return response()->json('Tạo request thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->requestModel->deleteRequest($id);
        return redirect()->back()->with('success', 'Hủy yêu cầu thành công');
    }
}
