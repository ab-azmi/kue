<?php

namespace App\Observers\Cake;

use App\Models\Cake\CakeComponentIngridient;
use App\Services\Constant\Activity\ActivityAction;

class IngridientObserver
{
    /**
     * Handle the Ingridient "created" event.
     */
    public function created(CakeComponentIngridient $ingridient): void
    {
        $ingridient->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Ingridient : ' . $ingridient->id);
    }

    public function updating(CakeComponentIngridient $ingridient): void
    {
        $ingridient->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the Ingridient "updated" event.
     */
    public function updated(CakeComponentIngridient $ingridient): void
    {
        $ingridient->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Ingridient : ' . $ingridient->id);
    }

    public function deleting(CakeComponentIngridient $ingridient): void
    {
        $ingridient->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the Ingridient "deleted" event.
     */
    public function deleted(CakeComponentIngridient $ingridient): void
    {
        $ingridient->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Ingridient : ' . $ingridient->id);
    }

    /**
     * Handle the Ingridient "restored" event.
     */
    public function restored(CakeComponentIngridient $ingridient): void
    {
        //
    }

    /**
     * Handle the Ingridient "force deleted" event.
     */
    public function forceDeleted(CakeComponentIngridient $ingridient): void
    {
        //
    }
}
