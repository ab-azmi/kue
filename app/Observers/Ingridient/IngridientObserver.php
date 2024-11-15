<?php

namespace App\Observers\Ingridient;

use App\Models\v1\Ingridient\Ingridient;
use App\Services\Constant\Activity\ActivityAction;

class IngridientObserver
{
    /**
     * Handle the Ingridient "created" event.
     */
    public function created(Ingridient $ingridient): void
    {
        $ingridient->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Ingridient : ' . $ingridient->id);
    }

    public function updating(Ingridient $ingridient): void
    {
        $ingridient->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the Ingridient "updated" event.
     */
    public function updated(Ingridient $ingridient): void
    {
        $ingridient->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Ingridient : ' . $ingridient->id);
    }

    public function deleting(Ingridient $ingridient): void
    {
        $ingridient->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the Ingridient "deleted" event.
     */
    public function deleted(Ingridient $ingridient): void
    {
        $ingridient->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Ingridient : ' . $ingridient->id);
    }

    /**
     * Handle the Ingridient "restored" event.
     */
    public function restored(Ingridient $ingridient): void
    {
        //
    }

    /**
     * Handle the Ingridient "force deleted" event.
     */
    public function forceDeleted(Ingridient $ingridient): void
    {
        //
    }
}
