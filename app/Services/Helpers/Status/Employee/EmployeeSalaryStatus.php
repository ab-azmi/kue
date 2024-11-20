<?php

if(!function_exists('errCreateSalary')){
    function errCreateSalary($internalMsg = "", $status = null){
        error(500, "An error occurred while creating Salary!", $internalMsg, $status);
    }
}

if(!function_exists('errUpdateSalary')){
    function errUpdateSalary($internalMsg = "", $status = null){
        error(500, "An error occurred while updating Salary!", $internalMsg, $status);
    }
}

if(!function_exists('errDeleteSalary')){
    function errDeleteSalary($internalMsg = "", $status = null){
        error(500, "An error occurred while deleting Salary!", $internalMsg, $status);
    }
}

if(!function_exists('errGetSalary')){
    function errGetSalary($internalMsg = "", $status = null){
        error(404, "salary not found!", $internalMsg, $status);
    }
}

