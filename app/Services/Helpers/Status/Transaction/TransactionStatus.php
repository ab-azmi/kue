<?php

if (!function_exists("errCreateTransaction")) {
    function errCreateTransaction($internalMsg = "", $status = null)
    {
        error(500, "Failed to create transaction!", $internalMsg, $status);
    }
}

if (!function_exists("errUpdateTransaction")) {
    function errUpdateTransaction($internalMsg = "", $status = null)
    {
        error(500, "Failed to update transaction!", $internalMsg, $status);
    }
}

if (!function_exists("errDeleteTransaction")) {
    function errDeleteTransaction($internalMsg = "", $status = null)
    {
        error(500, "Failed to delete transaction!", $internalMsg, $status);
    }
}

if(!function_exists("errGetTransaction")) {
    function errGetTransaction($internalMsg = "", $status = null)
    {
        error(404, "Transaction not found!", $internalMsg, $status);
    }
}

if (!function_exists("errValidationTransaction")) {
    function errValidationTransaction($internalMsg = "", $status = null)
    {
        error(422, "Transaction validation error!", $internalMsg, $status);
    }
}