<?php

namespace App\Services\Constant\Path;

class Path extends PathConstant
{
    /** --- BASE --- */

    public static function STORAGE_APP_PATH(string|null $filepath = null): string
    {
        return storage_path(self::STORAGE_APP . $filepath);
    }

    public static function STORAGE_PUBLIC_PATH(string|null $filepath = null): string
    {
        return storage_path(self::STORAGE_PUBLIC_APP . $filepath);
    }

}
