<?php

namespace App\Services\Constant\Setting;

use App\Services\Constant\BaseIDName;

class FrequencyConstant extends BaseIDName
{
    const MONTHLY_ID = 1;
    const MONTHLY = 'monthly';
    const QUARTERLY_ID = 2;
    const QUARTERLY = 'quarterly';
    const YEARLY_ID = 3;
    const YEARLY = 'yearly';
    const WEEKLY_ID = 4;
    const WEEKLY = 'weekly';

    const OPTION = [
        self::MONTHLY_ID => self::MONTHLY,
        self::QUARTERLY_ID => self::QUARTERLY,
        self::YEARLY_ID => self::YEARLY,
        self::WEEKLY_ID => self::WEEKLY,
    ];
}
