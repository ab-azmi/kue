<?php

namespace App\Services\Constant\Activity;

use App\Services\Constant\BaseCodeName;

class ActivityType extends BaseCodeName
{
    const GENERAL = 'general';
    const COMPONENT = 'component';

    const CAKE = 'cake';
    const INGRIDIENT = 'ingridient';
    const DISCOUNT = 'discount';
    const ORDER = 'order';
    const TRANSACTION = 'transaction';
    const USER = 'user';
    const SALARY = 'salary';
    const FIXEDCOST = 'fixedcost';
    

    const OPTION = [
        self::GENERAL,
        self::COMPONENT,
        self::CAKE,
        self::INGRIDIENT,
        self::DISCOUNT,
        self::ORDER,
        self::TRANSACTION,
        self::USER,
        self::SALARY,
        self::FIXEDCOST,
    ];

}
