<?php

if (!function_exists("errCreateSetting")) {
    function errCreateSetting($internalMsg = "", $status = null)
    {
        error(500, "Failed to Create Setting", $internalMsg, $status);
    }
}

if (!function_exists("errUpdateSetting")) {
    function errUpdateSetting($internalMsg = "", $status = null)
    {
        error(500, "Failed to Update Setting", $internalMsg, $status);
    }
}

if (!function_exists("errDeleteSetting")) {
    function errDeleteSetting($internalMsg = "", $status = null)
    {
        error(500, "Failed to Delete Setting", $internalMsg, $status);
    }
}

if (!function_exists("errGetSetting")) {
    function errGetSetting($data = null, $status = null)
    {
        success(404, "Setting not found!", $data, $status);
    }
}