<?php

namespace App\Observers\Cake;

use App\Models\Cake\CakeDiscount;
use App\Services\Constant\Activity\ActivityAction;

class DiscountObserver
{
    /**
     * Handle the Discount "created" event.
     */
    public function created(CakeDiscount $discount): void
    {
        $discount->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Discount : ' . $discount->id);
    }

    public function updating(CakeDiscount $discount): void
    {
        $discount->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the Discount "updated" event.
     */
    public function updated(CakeDiscount $discount): void
    {
        $discount->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Discount : ' . $discount->id);
    }

    public function deleting(CakeDiscount $discount): void
    {
        $discount->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the Discount "deleted" event.
     */
    public function deleted(CakeDiscount $discount): void
    {
        $discount->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Discount : ' . $discount->id);
    }

    /**
     * Handle the Discount "restored" event.
     */
    public function restored(CakeDiscount $discount): void
    {
        //
    }

    /**
     * Handle the Discount "force deleted" event.
     */
    public function forceDeleted(CakeDiscount $discount): void
    {
        //
    }
}
