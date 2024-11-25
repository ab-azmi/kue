<?php

namespace App\Services\Constant;

class BaseIDName
{
    const UNKNOWN = 'unknown';

    const OPTION = [
        0 => self::UNKNOWN,
    ];

    /** --- FUNCTIONS --- */
    public static function get(?array $options = null): array
    {
        if ($options) {
            return collect($options)->map(function ($option) {
                return ['id' => $option, 'name' => static::display($option)];
            })->toArray();
        }

        $data = [];
        foreach (static::OPTION as $key => $value) {
            $data[] = ['id' => $key, 'name' => $value];
        }

        return $data;
    }

    public static function display(?int $id = null): string
    {
        if (isset(static::OPTION[$id])) {
            return static::OPTION[$id];
        }

        return self::UNKNOWN;
    }

    public static function idName(?int $id = null): ?array
    {
        if (! $id) {
            return null;
        }

        return ['id' => $id, 'name' => static::display($id)];
    }
}
