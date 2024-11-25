<?php

use App\Services\Constant\Error;

if (! function_exists('errEmployeeCreate')) {
    function errEmployeeCreate($internalMsg = '', $status = null)
    {
        error(
            Error::EMPLOYEE['CREATE_FAILED']['code'],
            Error::EMPLOYEE['CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errEmployeeUpdate')) {
    function errEmployeeUpdate($internalMsg = '', $status = null)
    {
        error(
            Error::EMPLOYEE['UPDATE_FAILED']['code'],
            Error::EMPLOYEE['UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errEmployeeDelete')) {
    function errEmployeeDelete($internalMsg = '', $status = null)
    {
        error(
            Error::EMPLOYEE['DELETE_FAILED']['code'],
            Error::EMPLOYEE['DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errEmployeeGet')) {
    function errEmployeeGet($internalMsg = '', $status = null)
    {
        error(
            Error::EMPLOYEE['NOT_FOUND']['code'],
            Error::EMPLOYEE['NOT_FOUND']['msg'],
            $internalMsg,
            $status
        );
    }
}

/** --- EMPLOYEE USER --- **/
if (! function_exists('errEmployeeUserCreate')) {
    function errEmployeeUserCreate($internalMsg = '', $status = null)
    {
        error(
            Error::EMPLOYEE['USER_CREATE_FAILED']['code'],
            Error::EMPLOYEE['USER_CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errEmployeeUserUpdate')) {
    function errEmployeeUserUpdate($internalMsg = '', $status = null)
    {
        error(
            Error::EMPLOYEE['USER_UPDATE_FAILED']['code'],
            Error::EMPLOYEE['USER_UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

/** --- EMPLOYEE SALARY --- **/
if (! function_exists('errEmployeeSalaryUpdate')) {
    function errEmployeeSalaryUpdate($internalMsg = '', $status = null)
    {
        error(
            Error::EMPLOYEE['SALARY_UPDATE_FAILED']['code'],
            Error::EMPLOYEE['SALARY_UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (! function_exists('errEmployeeSalaryDelete')) {
    function errEmployeeSalaryDelete($internalMsg = '', $status = null)
    {
        error(
            Error::EMPLOYEE['SALARY_DELETE_FAILED']['code'],
            Error::EMPLOYEE['SALARY_DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}
