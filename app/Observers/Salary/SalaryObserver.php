<?php

namespace App\Observers\Salary;

use App\Models\Employee\EmployeeSalary;
use App\Services\Constant\Activity\ActivityAction;

class SalaryObserver
{
    /**
     * Handle the EmployeeSalary "created" event.
     */
    public function created(EmployeeSalary $salary): void
    {
        $salary->setActivityPropertyAttributes(ActivityAction::CREATE)
            ->saveActivity('Create new EmployeeSalary : ' . $salary->id);
    }

    public function updating(EmployeeSalary $salary): void
    {
        $salary->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the EmployeeSalary "updated" event.
     */
    public function updated(EmployeeSalary $salary): void
    {
        $salary->setActivityPropertyAttributes(ActivityAction::UPDATE)
            ->saveActivity('Update EmployeeSalary : ' . $salary->id);
    }

    public function deleting(EmployeeSalary $salary): void
    {
        $salary->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the EmployeeSalary "deleted" event.
     */
    public function deleted(EmployeeSalary $salary): void
    {
        $salary->setActivityPropertyAttributes(ActivityAction::DELETE)
            ->saveActivity('Delete EmployeeSalary : ' . $salary->id);
    }

    /**
     * Handle the EmployeeSalary "restored" event.
     */
    public function restored(EmployeeSalary $salary): void
    {
        //
    }

    /**
     * Handle the EmployeeSalary "force deleted" event.
     */
    public function forceDeleted(EmployeeSalary $salary): void
    {
        //
    }
}
