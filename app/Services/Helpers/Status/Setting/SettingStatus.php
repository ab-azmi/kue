<?php

use App\Services\Constant\Error;

if (!function_exists("errUpdateSetting")) {
    function errUpdateSetting($internalMsg = "", $status = null)
    {
        error(
            Error::SETTING['UPDATE_FAILED']['code'],
            Error::SETTING['UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errGetSetting")) {
    function errGetSetting($data = null, $status = null)
    {
        success(
            Error::SETTING['NOT_FOUND']['code'],
            Error::SETTING['UPDATE_FAILED']['msg'],
            $data,
            $status
        );
    }
}
