<?php
namespace App\Services\Constant\Setting;

use App\Services\Constant\BaseCodeName;

class FrequencyConstant extends BaseCodeName
{
    const MONTHLY = 'monthly';
    const MONTHLY_ID = 1;

    const QUARTERLY = 'quarterly';
    const QUARTERLY_ID = 2;

    const YEARLY = 'yearly';
    const YEARLY_ID = 3;

    const WEEKLY = 'weekly';
    const WEEKLY_ID = 4;

    const OPTION = [
        self::MONTHLY_ID => self::MONTHLY,
        self::QUARTERLY_ID => self::QUARTERLY,
        self::YEARLY_ID => self::YEARLY,
        self::WEEKLY_ID => self::WEEKLY,
    ];
}