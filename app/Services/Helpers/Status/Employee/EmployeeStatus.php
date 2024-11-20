<?php

if(!function_exists('errCreateEmployee')){
    function errCreateEmployee($internalMsg = "", $status = null){
        error(500, "An error occurred while creating employee!", $internalMsg, $status);
    }
}

if(!function_exists('errUpdateEmployee')){
    function errUpdateEmployee($internalMsg = "", $status = null){
        error(500, "An error occurred while updating employee!", $internalMsg, $status);
    }
}

if(!function_exists('errDeleteEmployee')){
    function errDeleteEmployee($internalMsg = "", $status = null){
        error(500, "An error occurred while deleting employee!", $internalMsg, $status);
    }
}

if(!function_exists('errGetEmployee')){
    function errGetEmployee($internalMsg = "", $status = null){
        error(404, "Employee not found!", $internalMsg, $status);
    }
}