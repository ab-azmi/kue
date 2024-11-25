<?php

namespace App\Services\Constant;

class Error extends BaseCodeName
{
    const EMPLOYEE = [
        'NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Employee Not Found',
        ],
        'CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Employee Create Failed',
        ],
        'UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Employee Update Failed',
        ],
        'DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'Employee Delete Failed',
        ],

        'USER_NOT_FOUND' => [
            'code' => 404,
            'msg' => 'User Not Found',
        ],
        'USER_CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'User Create Failed',
        ],
        'USER_UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'User Update Failed',
        ],
        'USER_DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'User Delete Failed',
        ],

        'SALARY_NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Salary Not Found',
        ],
        'SALARY_CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Salary Create Failed',
        ],
        'SALARY_UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Salary Update Failed',
        ],
        'SALARY_DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'Salary Delete Failed',
        ],
    ];

    const TRANSACTION = [
        'CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to create transaction!',
        ],
        'UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to update transaction!',
        ],
        'DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to delete transaction!',
        ],
        'NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Transaction not found!',
        ],

        'OUT_OF_STOCK_ORDER' => [
            'code' => 409,
            'msg' => 'Cake out of stock!',
        ],
        'ORDER_CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to create Order!',
        ],
        'FAILED_CALCULATE_TOTAL_PRICE' => [
            'code' => 500,
            'msg' => 'Failed to calculate total price!',
        ],
        'FAILED_CALCULATE_TOTAL_DISCOUNT' => [
            'code' => 500,
            'msg' => 'Failed to calculate total discount!',
        ],
        'FAILED_CALCULATE_TAX' => [
            'code' => 500,
            'msg' => 'Failed to calculate tax!',
        ],
    ];

    const CAKE = [
        'NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Cake Not Found',
        ],
        'CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Cake Create Failed',
        ],
        'UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Cake Update Failed',
        ],
        'DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'Cake Delete Failed',
        ],
        'UPLOAD_IMAGE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to upload image',
        ],

        'INGRIDIENT_NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Ingredient Not Found',
        ],
        'INGRIDIENT_CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Ingredient Create Failed',
        ],
        'INGRIDIENT_UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Ingredient Update Failed',
        ],
        'INGRIDIENT_DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'Ingredient Delete Failed',
        ],
        'SYNC_INGRIDIENTS_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to Sync Ingredients to Cake',
        ],
        'DECREMENT_INGRIDIENT_STOCK_FAILED' => [
            'code' => 409,
            'msg' => 'Ingredient Out of Stock',
        ],
        'CALCULATING_COGS_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to calculate Cost Of Goods Sold (COGS)',
        ],
        'CALCULATING_INGRIDIENT_COST_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to Calculate Total Cost of Ingredients',
        ],

        'DISCOUNT_NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Discount Not Found',
        ],
        'DISCOUNT_CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Discount Create Failed',
        ],
        'DISCOUNT_UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Discount Update Failed',
        ],
        'DISCOUNT_DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'Discount Delete Failed',
        ],
    ];

    const SETTING = [
        'UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to Update Setting',
        ],
        'NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Setting not found!',
        ],

        'FIXEDCOST_CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to Create Fixed Cost',
        ],
        'FIXEDCOST_UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to Update Fixed Cost',
        ],
        'FIXEDCOST_DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to Delete Fixed Cost',
        ],
        'FIXEDCOST_NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Fixed Cost Not Found',
        ],
    ];
}
