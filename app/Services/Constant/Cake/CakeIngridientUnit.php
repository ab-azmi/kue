<?php
namespace App\Services\Constant\Cake;

use App\Services\Constant\BaseCodeName;

class CakeIngridientUnit extends BaseCodeName
{
    const GRAM = 'gram';
    const GRAM_ID = 1;

    const KILOGRAM = 'kilogram';
    const KILOGRAM_ID = 2;

    const LITER = 'liter';
    const LITER_ID = 3;

    const PIECE = 'piece';
    const PIECE_ID = 4;

    const PACK = 'pack';
    const PACK_ID = 5;

    const OPTION = [
        self::GRAM_ID => self::GRAM,
        self::KILOGRAM_ID => self::KILOGRAM,
        self::LITER_ID => self::LITER,
        self::PIECE_ID => self::PIECE,
        self::PACK_ID => self::PACK,
    ];
}