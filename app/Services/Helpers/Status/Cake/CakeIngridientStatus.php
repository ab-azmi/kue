<?php


if (!function_exists("errAttachIngridients")) {
    function errAttachIngridients($internalMsg = "", $status = null)
    {
        error(500, "Failed to Attach Ingridients to Cake", $internalMsg, $status);
    }
}

if (!function_exists("errDetachingIngridients")) {
    function errDetachingIngridients($internalMsg = "", $status = null)
    {
        error(500, "Failed to Detach Ingridients to Cake", $internalMsg, $status);
    }
}

if (!function_exists("errDecrementingIngridientStock")) {
    function errDecrementingIngridientStock($internalMsg = "", $status = null)
    {
        error(409, "Ingridient Out of Stock", $internalMsg, $status);
    }
}

if (!function_exists("errCalculatingCOGS")) {
    function errCalculatingCOGS($internalMsg = "", $status = null)
    {
        error(500, "Failed to calculate Cost Of Goods Sold (COGS)", $internalMsg, $status);
    }
}

if (!function_exists("errCalculatingIngridientCost")) {
    function errCalculatingIngridientCost($internalMsg = "", $status = null)
    {
        error(500, "Failed to Calculate Total Cost of Ingridients", $internalMsg, $status);
    }
}
