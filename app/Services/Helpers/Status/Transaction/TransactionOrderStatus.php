<?php

if (!function_exists("errOutOfStockOrder")) {
    function errOutOfStockOrder($internalMsg = "", $status = null)
    {
        error(409, "Cake out of stock!", $internalMsg, $status);
    }
}

if (!function_exists("errCreateOrder")) {
    function errCreateOrder($internalMsg = "", $status = null)
    {
        error(500, "Failed to create Order!", $internalMsg, $status);
    }
}