<?php

use App\Services\Constant\Error;

if (!function_exists('errCreateEmployee')) {
    function errCreateEmployee($internalMsg = "", $status = null)
    {
        error(Error::EMPLOYEE['CREATE_FAILED']['code'], Error::EMPLOYEE['CREATE_FAILED']['msg'], $internalMsg, $status);
    }
}

if (!function_exists('errUpdateEmployee')) {
    function errUpdateEmployee($internalMsg = "", $status = null)
    {
        error(Error::EMPLOYEE['UPDATE_FAILED']['code'], Error::EMPLOYEE['UPDATE_FAILED']['msg'], $internalMsg, $status);
    }
}

if (!function_exists('errDeleteEmployee')) {
    function errDeleteEmployee($internalMsg = "", $status = null)
    {
        error(Error::EMPLOYEE['DELETE_FAILED']['code'], Error::EMPLOYEE['DELETE_FAILED']['msg'], $internalMsg, $status);
    }
}

if (!function_exists('errGetEmployee')) {
    function errGetEmployee($internalMsg = "", $status = null)
    {
        error(Error::EMPLOYEE['NOT_FOUND']['code'], Error::EMPLOYEE['NOT_FOUND']['msg'], $internalMsg, $status);
    }
}
