<?php

use App\Services\Constant\Error;

if (!function_exists("errOutOfStockOrder")) {
    function errOutOfStockOrder($internalMsg = "", $status = null)
    {
        error(
            Error::TRANSACTION['OUT_OF_STOCK_ORDER']['code'],
            Error::TRANSACTION['OUT_OF_STOCK_ORDER']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCreateOrder")) {
    function errCreateOrder($internalMsg = "", $status = null)
    {
        error(
            Error::TRANSACTION['ORDER_CREATE_FAILED']['code'],
            Error::TRANSACTION['ORDER_CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}