<?php

use App\Services\Constant\Error;

if (! function_exists('errTransactionCreate')) {
    function errTransactionCreate($internalMsg = '', $status = null)
    {
        error(
            Error::TRANSACTION['CREATE_FAILED']['code'],
            Error::TRANSACTION['CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errTransactionUpdate')) {
    function errTransactionUpdate($internalMsg = '', $status = null)
    {
        error(
            Error::TRANSACTION['UPDATE_FAILED']['code'],
            Error::TRANSACTION['UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errTransactionDelete')) {
    function errTransactionDelete($internalMsg = '', $status = null)
    {
        error(
            Error::TRANSACTION['DELETE_FAILED']['code'],
            Error::TRANSACTION['DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errTransactionGet')) {
    function errTransactionGet($internalMsg = '', $status = null)
    {
        error(
            Error::TRANSACTION['NOT_FOUND']['code'],
            Error::TRANSACTION['NOT_FOUND']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errTransactionTotalPrice')) {
    function errTransactionTotalPrice($internalMsg = '', $status = null)
    {
        error(
            Error::TRANSACTION['FAILED_CALCULATE_TOTAL_PRICE']['code'],
            Error::TRANSACTION['FAILED_CALCULATE_TOTAL_PRICE']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errTransactionTotalDiscount')) {
    function errTransactionTotalDiscount($internalMsg = '', $status = null)
    {
        error(
            Error::TRANSACTION['FAILED_CALCULATE_TOTAL_DISCOUNT']['code'],
            Error::TRANSACTION['FAILED_CALCULATE_TOTAL_DISCOUNT']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errTransactionTax')) {
    function errTransactionTax($internalMsg = '', $status = null)
    {
        error(
            Error::TRANSACTION['FAILED_CALCULATE_TAX']['code'],
            Error::TRANSACTION['FAILED_CALCULATE_TAX']['msg'],
            $internalMsg,
            $status
        );
    }
}

/** --- TRANSACTION ORDER --- **/
if (! function_exists('errOutOfStockOrder')) {
    function errOutOfStockOrder($internalMsg = '', $status = null)
    {
        error(
            Error::TRANSACTION['OUT_OF_STOCK_ORDER']['code'],
            Error::TRANSACTION['OUT_OF_STOCK_ORDER']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errCreateOrder')) {
    function errCreateOrder($internalMsg = '', $status = null)
    {
        error(
            Error::TRANSACTION['ORDER_CREATE_FAILED']['code'],
            Error::TRANSACTION['ORDER_CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}
