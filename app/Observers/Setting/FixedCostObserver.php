<?php

namespace App\Observers\Setting;

use App\Models\Setting\SettingFixedCost;
use App\Services\Constant\Activity\ActivityAction;

class FixedCostObserver
{
    /**
     * Handle the FixedCost "created" event.
     */
    public function created(SettingFixedCost $fixedCost): void
    {
        $fixedCost->setActivityPropertyAttributes(ActivityAction::CREATE)
            ->saveActivity('Create new Fixed Cost : ' . $fixedCost->id);
    }

    /**
     * Handle the SettingFixedCost "updated" event.
     */
    public function updating(SettingFixedCost $fixedCost): void
    {
        $fixedCost->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the SettingFixedCost "updated" event.
     */
    public function updated(SettingFixedCost $fixedCost): void
    {
        $fixedCost->setActivityPropertyAttributes(ActivityAction::UPDATE)
            ->saveActivity('Update Fixed Cost : ' . $fixedCost->id);
    }

    public function deleting(SettingFixedCost $fixedCost): void
    {
        $fixedCost->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the SettingFixedCost "deleted" event.
     */
    public function deleted(SettingFixedCost $fixedCost): void
    {
        $fixedCost->setActivityPropertyAttributes(ActivityAction::DELETE)
            ->saveActivity('Delete Fixed Cost : ' . $fixedCost->id);
    }

    /**
     * Handle the SettingFixedCost "restored" event.
     */
    public function restored(SettingFixedCost $fixedCost): void
    {
        //
    }

    /**
     * Handle the SettingFixedCost "force deleted" event.
     */
    public function forceDeleted(SettingFixedCost $fixedCost): void
    {
        //
    }
}
