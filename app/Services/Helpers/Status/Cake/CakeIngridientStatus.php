<?php

use App\Services\Constant\Error;

if (!function_exists("errAttachIngridients")) {
    function errAttachIngridients($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['ATTACH_INGRIDIENTS_FAILED']['code'],
            Error::CAKE['ATTACH_INGRIDIENTS_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errDetachingIngridients")) {
    function errDetachingIngridients($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['DETACH_INGRIDIENTS_FAILED']['code'],
            Error::CAKE['DETACH_INGRIDIENTS_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errDecrementingIngridientStock")) {
    function errDecrementingIngridientStock($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['DECREMENT_INGRIDIENT_STOCK_FAILED']['code'],
            Error::CAKE['DECREMENT_INGRIDIENT_STOCK_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCalculatingCOGS")) {
    function errCalculatingCOGS($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['CALCULATING_COGS_FAILED']['code'],
            Error::CAKE['CALCULATING_COGS_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCalculatingIngridientCost")) {
    function errCalculatingIngridientCost($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['CALCULATING_INGRIDIENT_COST_FAILED']['code'],
            Error::CAKE['CALCULATING_INGRIDIENT_COST_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}
