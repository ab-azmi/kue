<?php

if (!function_exists("errCreateFixedCost")) {
    function errCreateFixedCost($internalMsg = "", $status = null)
    {
        error(500, "Failed to Create Fixed Cost", $internalMsg, $status);
    }
}

if (!function_exists("errUpdateFixedCost")) {
    function errUpdateFixedCost($internalMsg = "", $status = null)
    {
        error(500, "Failed to Update Fixed Cost", $internalMsg, $status);
    }
}

if (!function_exists("errDeleteFixedCost")) {
    function errDeleteFixedCost($internalMsg = "", $status = null)
    {
        error(500, "Failed to Delete Fixed Cost", $internalMsg, $status);
    }
}

if (!function_exists("errGetFixedCost")) {
    function errGetFixedCost($data = null, $status = null)
    {
        success(404, "Fixed Cost Not Found!", $data, $status);
    }
}