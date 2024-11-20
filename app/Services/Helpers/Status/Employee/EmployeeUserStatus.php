<?php

if(!function_exists('errCreateUser')){
    function errCreateUser($internalMsg = "", $status = null){
        error(500, "An error occurred while creating user!", $internalMsg, $status);
    }
}

if(!function_exists('errUpdateUser')){
    function errUpdateUser($internalMsg = "", $status = null){
        error(500, "An error occurred while updating user!", $internalMsg, $status);
    }
}

if(!function_exists('errDeleteUser')){
    function errDeleteUser($internalMsg = "", $status = null){
        error(500, "An error occurred while deleting user!", $internalMsg, $status);
    }
}

if(!function_exists('errGetUser')){
    function errGetUser($internalMsg = "", $status = null){
        error(404, "User not found!", $internalMsg, $status);
    }
}