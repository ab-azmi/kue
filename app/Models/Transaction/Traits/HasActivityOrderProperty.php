<?php

namespace App\Models\Transaction\Traits;

use App\Models\Activity\Traits\HasActivity;
use App\Parser\Transaction\TransactionOrderParser;
use App\Services\Constant\Activity\ActivityType;

trait HasActivityOrderProperty
{
    use HasActivity;

    public function getActivityType(): string
    {
        return ActivityType::ORDER;
    }

    public function getActivitySubType(): string
    {
        return '';
    }

    /**
     * @return array
     */
    public function getActivityPropertyCreate()
    {
        return $this->setActivityPropertyParser();
    }

    /**
     * @return array
     */
    public function getActivityPropertyUpdate()
    {
        return $this->setActivityPropertyParser();
    }

    /**
     * @return array
     */
    public function getActivityPropertyDelete()
    {
        return $this->setActivityPropertyParser() + [
            'deletedAt' => $this->deletedAt?->format('d/m/Y H:i'),
        ];
    }

    /** --- FUNCTIONS --- */

    /**
     * @return array|null
     */
    private function setActivityPropertyParser()
    {
        $this->refresh();

        return TransactionOrderParser::brief($this);
    }
}
