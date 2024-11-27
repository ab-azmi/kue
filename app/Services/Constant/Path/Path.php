<?php

namespace App\Services\Constant\Path;

class Path extends PathConstant
{
    public static function STORAGE_APP_PATH(?string $path = null)
    {
        return storage_path(self::STORAGE_APP.($path ? '/'.$path : ''));
    }

    public static function STORAGE_PUBLIC_PATH(?string $path = null)
    {
        return storage_path(self::STORAGE_PUBLIC.($path ? '/'.$path : ''));
    }
}
