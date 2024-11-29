<?php

if (!function_exists('errEmployeeCreate')) {
    function errEmployeeCreate($internalMsg = '', $status = 500)
    {
        error($status, 'Employee Create Failed', $internalMsg);
    }
}

if (!function_exists('errEmployeeUpdate')) {
    function errEmployeeUpdate($internalMsg = '', $status = 500)
    {
        error($status, 'Employee Update Failed', $internalMsg);
    }
}

if (!function_exists('errEmployeeDelete')) {
    function errEmployeeDelete($internalMsg = '', $status = 500)
    {
        error($status, 'Employee Delete Failed', $internalMsg);
    }
}

if (!function_exists('errEmployeeGet')) {
    function errEmployeeGet($internalMsg = '', $status = 404)
    {
        error($status, 'Employee Not Found', $internalMsg);
    }
}

if(!function_exists('errEmployeeUploadProfile')){
    function errEmployeeUploadProfile($internalMsg = '', $status = 500){
        error($status, 'Employee Profile Upload Failed', $internalMsg);
    }
}

/** --- EMPLOYEE USER --- **/
if (!function_exists('errEmployeeUserCreate')) {
    function errEmployeeUserCreate($internalMsg = '', $status = 500)
    {
        error($status, 'User Create Failed', $internalMsg);
    }
}

if (!function_exists('errEmployeeUserUpdate')) {
    function errEmployeeUserUpdate($internalMsg = '', $status = 500)
    {
        error($status, 'User Update Failed', $internalMsg);
    }
}


/** --- EMPLOYEE SALARY --- **/

if (!function_exists('errEmployeeSalaryUpdate')) {
    function errEmployeeSalaryUpdate($internalMsg = '', $status = 500)
    {
        error($status, 'Employee Salary Update Failed', $internalMsg);
    }
}

if (!function_exists('errEmployeeSalaryDelete')) {
    function errEmployeeSalaryDelete($internalMsg = '', $status = 500)
    {
        error($status, 'Employee Salary Delete Failed', $internalMsg);
    }
}
