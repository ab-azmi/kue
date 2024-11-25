<?php

namespace App\Models\Cake\Traits;

use App\Models\Activity\Traits\HasActivity;
use App\Parser\Cake\CakeComponentIngredientParser;
use App\Services\Constant\Activity\ActivityType;

trait HasActivityCakeComponentIngredientProperty
{
    use HasActivity;

    public function getActivityType(): string
    {
        return ActivityType::INGRIDIENT;
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

        return CakeComponentIngredientParser::first($this);
    }
}
