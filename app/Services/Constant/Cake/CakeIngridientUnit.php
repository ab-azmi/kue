<?php
namespace App\Services\Constant\Cake;

use App\Services\Constant\BaseCodeName;

class CakeIngridientUnit extends BaseCodeName
{
    const GRAM_ID = 1;
    const GRAM = 'gram';

    const KILOGRAM_ID = 2;
    const KILOGRAM = 'kilogram';

    const LITER_ID = 3;
    const LITER = 'liter';

    const PIECE_ID = 4;
    const PIECE = 'piece';

    const PACK_ID = 5;
    const PACK = 'pack';

    const OPTION = [
        self::GRAM_ID => self::GRAM,
        self::KILOGRAM_ID => self::KILOGRAM,
        self::LITER_ID => self::LITER,
        self::PIECE_ID => self::PIECE,
        self::PACK_ID => self::PACK,
    ];
}