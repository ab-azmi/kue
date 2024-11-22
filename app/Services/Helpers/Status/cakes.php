<?php

use App\Services\Constant\Error;

if (!function_exists("errCakeCreate")) {
    function errCakeCreate($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['CREATE_FAILED']['code'],
            Error::CAKE['CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeUpdate")) {
    function errCakeUpdate($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['UPDATE_FAILED']['code'],
            Error::CAKE['UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeDelete")) {
    function errCakeDelete($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['DELETE_FAILED']['code'],
            Error::CAKE['DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeGet")) {
    function errCakeGet($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['NOT_FOUND']['code'],
            Error::CAKE['NOT_FOUND']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeUploadImage")) {
    function errCakeUploadImage($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['UPLOAD_IMAGE_FAILED']['code'],
            Error::CAKE['UPLOAD_IMAGE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

/** --- CAKE DISCOUNT --- **/

if (!function_exists("errCakeDiscountGet")) {
    function errCakeDiscountGet($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['DISCOUNT_NOT_FOUND']['code'],
            Error::CAKE['DISCOUNT_NOT_FOUND']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeDiscountCreate")) {
    function errCakeDiscountCreate($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['DISCOUNT_CREATE_FAILED']['code'],
            Error::CAKE['DISCOUNT_CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeDiscountUpdate")) {
    function errCakeDiscountUpdate($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['DISCOUNT_UPDATE_FAILED']['code'],
            Error::CAKE['DISCOUNT_UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeDiscountDelete")) {
    function errCakeDiscountDelete($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['DISCOUNT_DELETE_FAILED']['code'],
            Error::CAKE['DISCOUNT_DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

/** --- CAKE INGREDIENT --- **/

if (!function_exists("errCakeIngredientGet")) {
    function errCakeIngredientGet($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['INGRIDIENT_NOT_FOUND']['code'],
            Error::CAKE['INGRIDIENT_NOT_FOUND']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeIngredientUpdate")) {
    function errCakeIngredientUpdate($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['INGRIDIENT_UPDATE_FAILED']['code'],
            Error::CAKE['INGRIDIENT_UPDATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeIngredientCreate")) {
    function errCakeIngredientCreate($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['INGRIDIENT_CREATE_FAILED']['code'],
            Error::CAKE['INGRIDIENT_CREATE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeIngredientDelete")) {
    function errCakeIngredientDelete($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['INGRIDIENT_DELETE_FAILED']['code'],
            Error::CAKE['INGRIDIENT_DELETE_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeIngredientSync")) {
    function errCakeIngredientSync($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['SYNC_INGRIDIENTS_FAILED']['code'],
            Error::CAKE['SYNC_INGRIDIENTS_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeIngredientDecrementStock")) {
    function errCakeIngredientDecrementStock($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['DECREMENT_INGRIDIENT_STOCK_FAILED']['code'],
            Error::CAKE['DECREMENT_INGRIDIENT_STOCK_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeCOGS")) {
    function errCakeCOGS($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['CALCULATING_COGS_FAILED']['code'],
            Error::CAKE['CALCULATING_COGS_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}

if (!function_exists("errCakeIngredientTotalCost")) {
    function errCakeIngredientTotalCost($internalMsg = "", $status = null)
    {
        error(
            Error::CAKE['CALCULATING_INGRIDIENT_COST_FAILED']['code'],
            Error::CAKE['CALCULATING_INGRIDIENT_COST_FAILED']['msg'],
            $internalMsg,
            $status
        );
    }
}