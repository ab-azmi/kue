<?php

use App\Models\Activity\Activity;
use App\Services\Misc\SaveActivity;

if (! function_exists('activity')) {

    function activity(?string $log = null): SaveActivity
    {
        $activity = new SaveActivity(new Activity);

        if ($log) {
            $activity->setDescription($log);
        }

        return $activity;
    }

}
