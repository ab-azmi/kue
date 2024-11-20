<?php

namespace App\Services\Constant;

use App\Services\Constant\BaseCodeName;

class Error extends BaseCodeName
{
    const EMPLOYEE = [
        'NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Employee Not Found'
        ],
        'CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Employee Create Failed'
        ],
        'UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Employee Update Failed'
        ],
        'DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'Employee Delete Failed'
        ],

        'USER_NOT_FOUND' => [
            'code' => 404,
            'msg' => 'User Not Found'
        ],
        'USER_CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'User Create Failed'
        ],
        'USER_UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'User Update Failed'
        ],
        'USER_DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'User Delete Failed'
        ],

        'SALARY_NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Salary Not Found'
        ],
        'SALARY_CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Salary Create Failed'
        ],
        'SALARY_UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Salary Update Failed'
        ],
        'SALARY_DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'Salary Delete Failed'
        ],
    ];

    const TRANSACTION = [
        'CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to create transaction!'
        ],
        'UPDATE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to update transaction!'
        ],
        'DELETE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to delete transaction!'
        ],
        'NOT_FOUND' => [
            'code' => 404,
            'msg' => 'Transaction not found!'
        ],

        'OUT_OF_STOCK_ORDER' => [
            'code' => 409,
            'msg' => 'Cake out of stock!'
        ],
        'ORDER_CREATE_FAILED' => [
            'code' => 500,
            'msg' => 'Failed to create Order!'
        ],
    ];
}
