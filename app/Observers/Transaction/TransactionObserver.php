<?php

namespace App\Observers\Transaction;

use App\Models\v1\Transaction\Transaction;
use App\Services\Constant\Activity\ActivityAction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        $transaction->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Transaction : ' . $transaction->id);
    }

    public function updating(Transaction $transaction): void
    {
        $transaction->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        $transaction->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Transaction : ' . $transaction->id);
    }

    public function deleting(Transaction $transaction): void
    {
        $transaction->setOldActivityPropertyAttributes(ActivityAction::DELETE);
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        $transaction->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Transaction : ' . $transaction->id);
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
