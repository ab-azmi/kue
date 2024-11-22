<?php

namespace App\Services\Constant\Path;

class Path extends PathConstant
{
    public static function STORAGE_APP_PATH(string|null $path = null)
    {
        return storage_path(self::STORAGE_APP . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }

    public static function STORAGE_PUBLIC_PATH(string|null $path = null)
    {
        return storage_path(self::STORAGE_PUBLIC . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }

    /** --- CAKES PUBLIC --- **/

    public static function CAKE_URL_PATH(string|null $filename = null)
    {
        return url('api/web/v1/kue' . ($filename ? '/cakes/files/' . $filename : ''));
    }
}
