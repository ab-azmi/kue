<?php

use App\Services\Constant\Error;

if (! function_exists('errSettingUpdate')) {
    function errSettingUpdate($internalMsg = '', $status = null)
    {
        error(
            Error::SETTING['UPDATE_FAILED']['code'],
            Error::SETTING['UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errSettingGet')) {
    function errSettingGet($data = null, $status = null)
    {
        success(
            Error::SETTING['NOT_FOUND']['code'],
            Error::SETTING['UPDATE_FAILED']['msg'],
            $data,
            $status
        );
    }
}

/** --- FIXED COST --- **/
if (! function_exists('errSettingFixedCostCreate')) {
    function errSettingFixedCostCreate($internalMsg = '', $status = null)
    {
        error(
            Error::SETTING['FIXEDCOST_CREATE_FAILED']['code'],
            Error::SETTING['FIXEDCOST_CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errSettingFixedCostUpdate')) {
    function errSettingFixedCostUpdate($internalMsg = '', $status = null)
    {
        error(
            Error::SETTING['FIXEDCOST_UPDATE_FAILED']['code'],
            Error::SETTING['FIXEDCOST_UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errSettingFixedCostDelete')) {
    function errSettingFixedCostDelete($internalMsg = '', $status = null)
    {
        error(
            Error::SETTING['FIXEDCOST_DELETE_FAILED']['code'],
            Error::SETTING['FIXEDCOST_DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errSettingFixedCostGet')) {
    function errSettingFixedCostGet($internalMsg = '', $status = null)
    {
        error(
            Error::SETTING['FIXEDCOST_NOT_FOUND']['code'],
            Error::SETTING['FIXEDCOST_NOT_FOUND']['msg'],
            $internalMsg,
            $status
        );
    }
}
