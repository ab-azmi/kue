<?php

namespace App\Observers\Cake;

use App\Models\Cake\Discount;
use App\Services\Constant\Activity\ActivityAction;

class DiscountObserver
{
    /**
     * Handle the Discount "created" event.
     */
    public function created(Discount $discount): void
    {
        $discount->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Discount : ' . $discount->id);
    }

    public function updating(Discount $discount): void
    {
        $discount->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the Discount "updated" event.
     */
    public function updated(Discount $discount): void
    {
        $discount->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Discount : ' . $discount->id);
    }

    public function deleting(Discount $discount): void
    {
        $discount->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the Discount "deleted" event.
     */
    public function deleted(Discount $discount): void
    {
        $discount->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Discount : ' . $discount->id);
    }

    /**
     * Handle the Discount "restored" event.
     */
    public function restored(Discount $discount): void
    {
        //
    }

    /**
     * Handle the Discount "force deleted" event.
     */
    public function forceDeleted(Discount $discount): void
    {
        //
    }
}
