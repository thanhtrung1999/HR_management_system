<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TimeSheetExportView implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        $data = session('data_timesheet');
        return view('employees.managers.working-schedules.timesheet', $data);
    }
}
