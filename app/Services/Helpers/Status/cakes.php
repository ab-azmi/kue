<?php

if (! function_exists('errCakeCreate')) {
    function errCakeCreate($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to create cake', $internalMsg);
    }
}

if (! function_exists('errCakeUpdate')) {
    function errCakeUpdate($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to update cake', $internalMsg);
    }
}

if (! function_exists('errCakeDelete')) {
    function errCakeDelete($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to delete cake', $internalMsg);
    }
}

if (! function_exists('errCakeGet')) {
    function errCakeGet($internalMsg = '', $status = 404)
    {
        error($status, 'Cake not found', $internalMsg);
    }
}

if (! function_exists('errCakeUploadImage')) {
    function errCakeUploadImage($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to upload image', $internalMsg);
    }
}

/** --- CAKE DISCOUNT --- **/
if (! function_exists('errCakeDiscountGet')) {
    function errCakeDiscountGet($internalMsg = '', $status = 404)
    {
        error($status, 'Failed to get cake discount', $internalMsg);
    }
}

if (! function_exists('errCakeDiscountCreate')) {
    function errCakeDiscountCreate($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to create cake discount', $internalMsg);
    }
}

if (! function_exists('errCakeDiscountUpdate')) {
    function errCakeDiscountUpdate($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to update cake discount', $internalMsg);
    }
}

if (! function_exists('errCakeDiscountDelete')) {
    function errCakeDiscountDelete($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to delete cake discount', $internalMsg);
    }
}

/** --- CAKE INGREDIENT --- **/
if (! function_exists('errCakeIngredientGet')) {
    function errCakeIngredientGet($internalMsg = '', $status = 404)
    {
        error($status, 'Failed to get cake ingredient', $internalMsg);
    }
}

if (! function_exists('errCakeIngredientUpdate')) {
    function errCakeIngredientUpdate($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to update cake ingredient', $internalMsg);
    }
}

if (! function_exists('errCakeIngredientCreate')) {
    function errCakeIngredientCreate($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to create cake ingredient', $internalMsg);
    }
}

if (! function_exists('errCakeIngredientDelete')) {
    function errCakeIngredientDelete($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to delete cake ingredient', $internalMsg);
    }
}

if (! function_exists('errCakeIngredientSync')) {
    function errCakeIngredientSync($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to sync cake ingredient', $internalMsg);
    }
}

if (! function_exists('errCakeIngredientAdjustStock')) {
    function errCakeIngredientAdjustStock($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to adjust stock', $internalMsg);
    }
}

if (! function_exists('errCakeCOGS')) {
    function errCakeCOGS($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to calculate COGS', $internalMsg);
    }
}

if (! function_exists('errCakeIngredientTotalCost')) {
    function errCakeIngredientTotalCost($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to calculate total cost', $internalMsg);
    }
}



/** --- CAKE VARIANT --- **/

if(!function_exists('errCakeVariantGet')) {
    function errCakeVariantGet($internalMsg = '', $status = 404)
    {
        error($status, 'Cake variant not found', $internalMsg);
    }
}

if(!function_exists('errCakeVariantCreate')) {
    function errCakeVariantCreate($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to create cake variant', $internalMsg);
    }
}

if(!function_exists('errCakeVariantUpdate')) {
    function errCakeVariantUpdate($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to update cake variant', $internalMsg);
    }
}

if(!function_exists('errCakeVariantDelete')) {
    function errCakeVariantDelete($internalMsg = '', $status = 500)
    {
        error($status, 'Failed to delete cake variant', $internalMsg);
    }
}
