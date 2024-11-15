<?php

namespace App\Observers\Salary;

use App\Models\v1\Salary\Salary;
use App\Services\Constant\Activity\ActivityAction;

class SalaryObserver
{
    /**
     * Handle the Salary "created" event.
     */
    public function created(Salary $salary): void
    {
        $salary->setActivityPropertyAttributes(ActivityAction::CREATE)
            ->saveActivity('Create new Salary : ' . $salary->id);
    }

    public function updating(Salary $salary): void
    {
        $salary->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the Salary "updated" event.
     */
    public function updated(Salary $salary): void
    {
        $salary->setActivityPropertyAttributes(ActivityAction::UPDATE)
            ->saveActivity('Update Salary : ' . $salary->id);
    }

    public function deleting(Salary $salary): void
    {
        $salary->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the Salary "deleted" event.
     */
    public function deleted(Salary $salary): void
    {
        $salary->setActivityPropertyAttributes(ActivityAction::DELETE)
            ->saveActivity('Delete Salary : ' . $salary->id);
    }

    /**
     * Handle the Salary "restored" event.
     */
    public function restored(Salary $salary): void
    {
        //
    }

    /**
     * Handle the Salary "force deleted" event.
     */
    public function forceDeleted(Salary $salary): void
    {
        //
    }
}
