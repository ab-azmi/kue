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
