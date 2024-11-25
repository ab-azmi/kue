<?php

namespace App\Services\Misc;

use App\Models\Activity\Activity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SaveActivity
{
    public function __construct(public Activity $activity) {}

    /**
     * @return SaveActivity
     */
    public function setType(string $type)
    {
        $this->activity->type = $type;

        return $this;
    }

    /**
     * @return SaveActivity
     */
    public function setSubType(string $subType)
    {
        $this->activity->subType = $subType;

        return $this;
    }

    /**
     * @return SaveActivity
     */
    public function setAction(string $action)
    {
        $this->activity->action = $action;

        return $this;
    }

    /**
     * @return SaveActivity
     */
    public function setCaused()
    {
        // TODO: Change to auth_company_office_ids() after install globalxtreme/laravel-identifier.
        //        if ($user = auth_user()) {
        //            $this->activity->causedBy = $user['id'];
        //            $this->activity->causedByName = $user['fullName'];
        //        }

        return $this;
    }

    /**
     * @return SaveActivity
     */
    public function setReference(Model $reference)
    {
        $this->activity->referable()->associate($reference);

        return $this;
    }

    /**
     * @return SaveActivity
     */
    public function setDescription(string $description)
    {
        $this->activity->description = $description;

        return $this;
    }

    /**
     * @return SaveActivity
     */
    public function setProperties(array|string $properties)
    {
        $this->activity->properties = is_string($properties) ? [$properties] : $properties;

        return $this;
    }

    /**
     * @return SaveActivity
     */
    public function setCreatedAt(Carbon $date)
    {
        $this->activity->{Activity::CREATED_AT} = $date;

        return $this;
    }

    /**
     * @return Activity
     */
    public function log(?string $description = null)
    {
        if (! $this->activity->causedBy) {

            // TODO: Change to auth_company_office_ids() after install globalxtreme/laravel-identifier.
            //            if ($user = auth_user()) {
            //                $this->activity->causedBy = $user['id'];
            //                $this->activity->causedByName = $user['fullName'];
            //            }

        }

        if ($description) {
            $this->setDescription($description);
        }

        $this->activity->save();

        return $this->activity;
    }
}
