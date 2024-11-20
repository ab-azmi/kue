<?php

if (!function_exists("errCreateCake")) {
    function errCreateCake($internalMsg = "", $status = null)
    {
        error(500, "Failed to create cake!", $internalMsg, $status);
    }
}

if (!function_exists("errUpdateCake")) {
    function errUpdateCake($internalMsg = "", $status = null)
    {
        error(500, "Failed to update cake!", $internalMsg, $status);
    }
}

if (!function_exists("errDeleteCake")) {
    function errDeleteCake($internalMsg = "", $status = null)
    {
        error(500, "Failed to delete cake!", $internalMsg, $status);
    }
}

if(!function_exists("errGetCake")) {
    function errGetCake($internalMsg = "", $status = null)
    {
        error(404, "Cake not found!", $internalMsg, $status);
    }
}

if (!function_exists("errValidationCake")) {
    function errValidationCake($internalMsg = "", $status = null)
    {
        error(422, "Cake validation error!", $internalMsg, $status);
    }
}


