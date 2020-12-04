<?php

namespace App\Http\Controllers\Employee\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagedEmployeeRequestController extends Controller
{
    public function getListRequests(){
        $managerId = auth('employees')->user()->id;
        $requests = $this->requestModel->getListRequestsByManagerId($managerId);

        return view('employees.managers.requests.index', [
            'requests' => $requests
        ]);
    }

    public function approvalRequest($id){
        $request = $this->requestModel->getRequestsById($id);
        if ($request->approval_by == 2){
            return redirect()->back()->with('error', 'Yêu cầu đã được root duyệt');
        }
        $request->status = 1;
        $request->approval_by = 1;
        $request->save();

        return redirect()->back()->with('success', 'Duyệt yêu cầu thành công');
    }

    public function cancelRequest($id){
        $request = $this->requestModel->getRequestsById($id);
        if ($request->approval_by == 1){
            return redirect()->back()->with('error', 'Yêu cầu đã được root duyệt');
        }
        $request->status = 2;
        $request->approval_by = 1;
        $request->save();

        return redirect()->back()->with('success', 'Hủy yêu cầu thành công');
    }
}
