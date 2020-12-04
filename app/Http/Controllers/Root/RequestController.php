<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function getListRequests(){
        $requests = $this->requestModel->getListRequests();
        return view('root.requests.index', [
            'requests' => $requests
        ]);
    }

    public function approvalRequest($id){
        $request = $this->requestModel->getRequestsById($id);
        if ($request->approval_by == 1){
            return redirect()->back()->with('error', 'Yêu cầu đã được trưởng phòng duyệt');
        }
        $request->status = 1;
        $request->approval_by = 2;
        $request->save();

        return redirect()->back()->with('success', 'Duyệt yêu cầu thành công');
    }

    public function cancelRequest($id){
        $request = $this->requestModel->getRequestsById($id);
        if ($request->approval_by == 1){
            return redirect()->back()->with('error', 'Yêu cầu đã được trưởng phòng duyệt');
        }
        $request->status = 2;
        $request->approval_by = 2;
        $request->save();

        return redirect()->back()->with('success', 'Hủy yêu cầu thành công');
    }
}
