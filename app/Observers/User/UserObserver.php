<?php

namespace App\Observers\User;

use App\Models\User\User;
use App\Services\Constant\Activity\ActivityAction;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->setActivityPropertyAttributes(ActivityAction::CREATE)
            ->saveActivity('Create new User : ' . $user->id);
    }

    public function updating(User $user): void
    {
        $user->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $user->setActivityPropertyAttributes(ActivityAction::UPDATE)
            ->saveActivity('Update User : ' . $user->id);
    }

    public function deleting(User $user): void
    {
        $user->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $user->setActivityPropertyAttributes(ActivityAction::DELETE)
            ->saveActivity('Delete User : ' . $user->id);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
