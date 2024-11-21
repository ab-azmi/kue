<?php

use App\Services\Constant\Error;

if (!function_exists("errCreateTransaction")) {
    function errCreateTransaction($internalMsg = "", $status = null)
    {
        error(
            Error::TRANSACTION['CREATE_FAILED']['code'],
            Error::TRANSACTION['CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errUpdateTransaction")) {
    function errUpdateTransaction($internalMsg = "", $status = null)
    {
        error(
            Error::TRANSACTION['UPDATE_FAILED']['code'],
            Error::TRANSACTION['UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errDeleteTransaction")) {
    function errDeleteTransaction($internalMsg = "", $status = null)
    {
        error(
            Error::TRANSACTION['DELETE_FAILED']['code'],
            Error::TRANSACTION['DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errGetTransaction")) {
    function errGetTransaction($internalMsg = "", $status = null)
    {
        error(
            Error::TRANSACTION['NOT_FOUND']['code'],
            Error::TRANSACTION['NOT_FOUND']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errTransactionTotalPrice")) {
    function errTransactionTotalPrice($internalMsg = "", $status = null)
    {
        error(
            Error::TRANSACTION['FAILED_CALCULATE_TOTAL_PRICE']['code'],
            Error::TRANSACTION['FAILED_CALCULATE_TOTAL_PRICE']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errTransactionTotalDiscount")) {
    function errTransactionTotalDiscount($internalMsg = "", $status = null)
    {
        error(
            Error::TRANSACTION['FAILED_CALCULATE_TOTAL_DISCOUNT']['code'],
            Error::TRANSACTION['FAILED_CALCULATE_TOTAL_DISCOUNT']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errTransactionTax")) {
    function errTransactionTax($internalMsg = "", $status = null)
    {
        error(
            Error::TRANSACTION['FAILED_CALCULATE_TAX']['code'],
            Error::TRANSACTION['FAILED_CALCULATE_TAX']['msg'],
            $internalMsg,
            $status
        );
    }
}
