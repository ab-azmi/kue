<?php

namespace App\Services\Constant\Transaction;

use App\Services\Constant\BaseIDName;

class TransactionStatusConstant extends BaseIDName
{
    const SUCCESS_ID = 1;
    const SUCCESS = 'success';
    const CANCELLED_ID = 2;
    const CANCELLED = 'cancelled';

    const OPTION = [
        self::SUCCESS_ID => self::SUCCESS,
        self::CANCELLED_ID => self::CANCELLED,
    ];
}
