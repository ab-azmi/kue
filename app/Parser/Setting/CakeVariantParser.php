<?php

namespace App\Parser\Setting;

use GlobalXtreme\Parser\BaseParser;

class CakeVariantParser extends BaseParser
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

        return parent::first($data);
    }

    public static function brief($data)
    {
        if (!$data) {
            return null;
        }

        return [
            'id' => $data->id,
            'name' => $data->name,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
        ];
    }

}
