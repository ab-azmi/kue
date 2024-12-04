<?php

namespace App\Services\Constant\Setting;

class SettingConstant
{
    const TAX_KEY = 'tax';
    const PROFIT_MARGIN_KEY = 'profit_margin';
    const SALARY_TO_CAKE_PERCENTAGE_KEY = 'salary_to_cake_percentage';
    const FIXED_COST_TO_CAKE_PERCENTAGE_KEY = 'fixed_cost_to_cake_percentage';

    const OPTION = [
        self::TAX_KEY,
        self::PROFIT_MARGIN_KEY,
        self::SALARY_TO_CAKE_PERCENTAGE_KEY,
        self::FIXED_COST_TO_CAKE_PERCENTAGE_KEY,
    ];
}
