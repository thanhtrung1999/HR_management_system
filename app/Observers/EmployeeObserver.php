<?php

namespace App\Observers;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeObserver
{
    /**
     * Handle the Employee "creating" event.
     *
     * @param Employee $employee
     * @return void
     */
    public function creating(Employee $employee)
    {
        $employee->password = Hash::make($employee->password);
    }

    /**
     * Handle the Employee "created" event.
     *
     * @param Employee $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "updating" event.
     *
     * @param Employee $employee
     * @return void
     */
    public function updating(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "updated" event.
     *
     * @param Employee $employee
     * @return void
     */
    public function updated(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "deleted" event.
     *
     * @param Employee $employee
     * @return void
     */
    public function deleted(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "restored" event.
     *
     * @param Employee $employee
     * @return void
     */
    public function restored(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "force deleted" event.
     *
     * @param Employee $employee
     * @return void
     */
    public function forceDeleted(Employee $employee)
    {
        //
    }
}
