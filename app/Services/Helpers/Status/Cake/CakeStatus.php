<?php

use App\Services\Constant\Error;

if (!function_exists("errCreateCake")) {
    function errCreateCake($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['CREATE_FAILED']['code'],
            Error::CAKE['CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errUpdateCake")) {
    function errUpdateCake($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['UPDATE_FAILED']['code'],
            Error::CAKE['UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errDeleteCake")) {
    function errDeleteCake($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['DELETE_FAILED']['code'],
            Error::CAKE['DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errGetCake")) {
    function errGetCake($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['NOT_FOUND']['code'],
            Error::CAKE['NOT_FOUND']['msg'],
            $internalMsg,
            $status
        );
    }
}