<?php

namespace App\Observers\Cake;

use App\Models\Cake\Cake;
use App\Services\Constant\Activity\ActivityAction;

class CakeObserver
{
    /**
     * Handle the Cake "created" event.
     */
    public function created(Cake $cake): void
    {
        $cake->setActivityPropertyAttributes(ActivityAction::CREATE)
            ->saveActivity('Create new Cake : ' . $cake->id);
    }

    public function updating(Cake $cake): void
    {
        $cake->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the Cake "updated" event.
     */
    public function updated(Cake $cake): void
    {
        $cake->setActivityPropertyAttributes(ActivityAction::UPDATE)
            ->saveActivity('Update Cake : ' . $cake->id);
    }

    public function deleting(Cake $cake): void
    {
        $cake->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the Cake "deleted" event.
     */
    public function deleted(Cake $cake): void
    {
        $cake->setActivityPropertyAttributes(ActivityAction::DELETE)
            ->saveActivity('Delete Cake : ' . $cake->id);
    }

    /**
     * Handle the Cake "restored" event.
     */
    public function restored(Cake $cake): void
    {
        //
    }

    /**
     * Handle the Cake "force deleted" event.
     */
    public function forceDeleted(Cake $cake): void
    {
        //
    }
}
