<?php

use App\Services\Constant\Error;

if (!function_exists("errCreateFixedCost")) {
    function errCreateFixedCost($internalMsg = "", $status = null)
    {
        error(
            Error::SETTING['FIXEDCOST_CREATE_FAILED']['code'],
            Error::SETTING['FIXEDCOST_CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errUpdateFixedCost")) {
    function errUpdateFixedCost($internalMsg = "", $status = null)
    {
        error(
            Error::SETTING['FIXEDCOST_UPDATE_FAILED']['code'],
            Error::SETTING['FIXEDCOST_UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errDeleteFixedCost")) {
    function errDeleteFixedCost($internalMsg = "", $status = null)
    {
        error(
            Error::SETTING['FIXEDCOST_DELETE_FAILED']['code'],
            Error::SETTING['FIXEDCOST_DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errGetFixedCost")) {
    function errGetFixedCost($internalMsg = "", $status = null)
    {
        error(
            Error::SETTING['FIXEDCOST_NOT_FOUND']['code'],
            Error::SETTING['FIXEDCOST_NOT_FOUND']['msg'],
            $internalMsg,
            $status
        );
    }
}