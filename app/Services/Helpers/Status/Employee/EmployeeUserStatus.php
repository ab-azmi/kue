<?php

use App\Services\Constant\Error;

if(!function_exists('errCreateUser')){
    function errCreateUser($internalMsg = "", $status = null){
        error(Error::EMPLOYEE['USER_CREATE_FAILED']['code'], Error::EMPLOYEE['USER_CREATE_FAILED']['msg'], $internalMsg, $status);
    }
}

if(!function_exists('errUpdateUser')){
    function errUpdateUser($internalMsg = "", $status = null){
        error(Error::EMPLOYEE['USER_UPDATE_FAILED']['code'], Error::EMPLOYEE['USER_UPDATE_FAILED']['msg'], $internalMsg, $status);
    }
}

if(!function_exists('errDeleteUser')){
    function errDeleteUser($internalMsg = "", $status = null){
        error(Error::EMPLOYEE['USER_DELETE_FAILED']['code'], Error::EMPLOYEE['USER_DELETE_FAILED']['msg'], $internalMsg, $status);
    }
}

if(!function_exists('errGetUser')){
    function errGetUser($internalMsg = "", $status = null){
        error(Error::EMPLOYEE['USER_NOT_FOUND']['code'], Error::EMPLOYEE['USER_NOT_FOUND']['msg'], $internalMsg, $status);
    }
}