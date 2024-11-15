<?php

namespace App\Services\Constant\Cake;

use App\Services\Constant\BaseCodeName;

class Tax extends BaseCodeName
{
    public const TAX_0 = 0;
    public const TAX_5 = .05;
    public const TAX_10 = .1;
    public const TAX_15 = .15;
    public const TAX_20 = .2;

    const OPTION = [
        self::TAX_0,
        self::TAX_5,
        self::TAX_10,
        self::TAX_15,
        self::TAX_20
    ];
}
