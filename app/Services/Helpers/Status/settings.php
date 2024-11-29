<?php

if (!function_exists('errSettingUpdate')) {
    function errSettingUpdate($internalMsg = '', $status = 500)
    {
        error($status, 'Setting Update Failed', $internalMsg);
    }
}

if (!function_exists('errSettingGet')) {
    function errSettingGet($data = null, $status = 404)
    {
        success($status, 'Setting Not Found', $data);
    }
}

/** --- FIXED COST --- **/
if (!function_exists('errSettingFixedCostCreate')) {
    function errSettingFixedCostCreate($internalMsg = '', $status = 500)
    {
        error($status, 'Fixed Cost Create Failed', $internalMsg);
    }
}

if (!function_exists('errSettingFixedCostUpdate')) {
    function errSettingFixedCostUpdate($internalMsg = '', $status = 500)
    {
        error($status, 'Fixed Cost Update Failed', $internalMsg);
    }
}

if (!function_exists('errSettingFixedCostDelete')) {
    function errSettingFixedCostDelete($internalMsg = '', $status = 500)
    {
        error($status, 'Fixed Cost Delete Failed', $internalMsg);
    }
}

if (!function_exists('errSettingFixedCostGet')) {
    function errSettingFixedCostGet($internalMsg = '', $status = 404)
    {
        error($status, 'Fixed Cost Not Found', $internalMsg);
    }
}
