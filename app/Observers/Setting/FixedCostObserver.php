<?php

namespace App\Observers\Setting;

use App\Models\v1\Setting\FixedCost;
use App\Services\Constant\Activity\ActivityAction;

class FixedCostObserver
{
    /**
     * Handle the FixedCost "created" event.
     */
    public function created(FixedCost $fixedCost): void
    {
        $fixedCost->setActivityPropertyAttributes(ActivityAction::CREATE)
            ->saveActivity('Create new Fixed Cost : ' . $fixedCost->id);
    }

    /**
     * Handle the FixedCost "updated" event.
     */
    public function updating(FixedCost $fixedCost): void
    {
        $fixedCost->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the FixedCost "updated" event.
     */
    public function updated(FixedCost $fixedCost): void
    {
        $fixedCost->setActivityPropertyAttributes(ActivityAction::UPDATE)
            ->saveActivity('Update Fixed Cost : ' . $fixedCost->id);
    }

    public function deleting(FixedCost $fixedCost): void
    {
        $fixedCost->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the FixedCost "deleted" event.
     */
    public function deleted(FixedCost $fixedCost): void
    {
        $fixedCost->setActivityPropertyAttributes(ActivityAction::DELETE)
            ->saveActivity('Delete Fixed Cost : ' . $fixedCost->id);
    }

    /**
     * Handle the FixedCost "restored" event.
     */
    public function restored(FixedCost $fixedCost): void
    {
        //
    }

    /**
     * Handle the FixedCost "force deleted" event.
     */
    public function forceDeleted(FixedCost $fixedCost): void
    {
        //
    }
}
