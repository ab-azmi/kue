<?php

if (!function_exists("errDefault")) {
    function errDefault($internalMsg = "", $status = null)
    {
        error(500, "An error occurred!", $internalMsg, $status);
    }
}

if (!function_exists("errUnauthorized")) {
    function errUnauthorized($internalMsg = "", $status = null)
    {
        error(401, "Unauthorized!", $internalMsg, $status);
    }
}
