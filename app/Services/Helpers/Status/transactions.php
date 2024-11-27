<?php

if (! function_exists('errTransactionCreate')) {
    function errTransactionCreate($internalMsg = '', $status = 500)
    {
        error($status, 'Transaction Create Failed', $internalMsg);
    }
}

if (! function_exists('errTransactionUpdate')) {
    function errTransactionUpdate($internalMsg = '', $status = 500)
    {
        error($status, 'Transaction Update Failed', $internalMsg);
    }
}

if (! function_exists('errTransactionDelete')) {
    function errTransactionDelete($internalMsg = '', $status = 500)
    {
        error($status, 'Transaction Delete Failed', $internalMsg);
    }
}

if (! function_exists('errTransactionGet')) {
    function errTransactionGet($internalMsg = '', $status = 404)
    {
        error($status, 'Transaction Not Found', $internalMsg);
    }
}

if (! function_exists('errTransactionTotalPrice')) {
    function errTransactionTotalPrice($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to calculate total price', $internalMsg);
    }
}

if (! function_exists('errTransactionTotalDiscount')) {
    function errTransactionTotalDiscount($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to calculate total discount', $internalMsg);
    }
}

if (! function_exists('errTransactionTax')) {
    function errTransactionTax($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to calculate tax', $internalMsg);
    }
}


/** --- TRANSACTION ORDER --- **/

if (! function_exists('errOutOfStockOrder')) {
    function errOutOfStockOrder($internalMsg = '', $status = 500)
    {
        error($status, 'Cake out of stock', $internalMsg);
    }
}

if (! function_exists('errCreateOrder')) {
    function errCreateOrder($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to create Order', $internalMsg);
    }
}
