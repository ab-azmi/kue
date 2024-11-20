<?php

use App\Services\Constant\Error;

if (!function_exists('errCreateSalary')) {
    function errCreateSalary($internalMsg = "", $status = null)
    {
        error(
            Error::EMPLOYEE['SALARY_CREATE_FAILED']['code'],
            Error::EMPLOYEE['SALARY_CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists('errUpdateSalary')) {
    function errUpdateSalary($internalMsg = "", $status = null)
    {
        error(
            Error::EMPLOYEE['SALARY_UPDATE_FAILED']['code'],
            Error::EMPLOYEE['SALARY_UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists('errDeleteSalary')) {
    function errDeleteSalary($internalMsg = "", $status = null)
    {
        error(
            Error::EMPLOYEE['SALARY_DELETE_FAILED']['code'],
            Error::EMPLOYEE['SALARY_DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists('errGetSalary')) {
    function errGetSalary($internalMsg = "", $status = null)
    {
        error(
            Error::EMPLOYEE['SALARY_NOT_FOUND']['code'],
            Error::EMPLOYEE['SALARY_NOT_FOUND']['msg'],
            $internalMsg,
            $status
        );
    }
}
