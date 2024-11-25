<?php

namespace App\Models\Setting\Traits;

use App\Models\Activity\Traits\HasActivity;
use App\Services\Constant\Activity\ActivityType;

trait HasActivitySettingProperty
{
    use HasActivity;

    public function getActivityType(): string
    {
        return ActivityType::GENERAL;
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

        return [];
    }
}
