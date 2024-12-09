<?php

namespace App\Parser\Setting;

use GlobalXtreme\Parser\BaseParser;

class SettingParser extends BaseParser
{
    /**
     * @param $data
     *
     * @return array|null
     */
    public static function first($data)
    {
        if (!$data) {
            return null;
        }

        return [
            'id' => $data->id,
            'key' => $data->key,
            'value' => $data->value,
            'description' => $data->description,
        ];
    }

}
