<?php

namespace App\Parser\Setting;

use GlobalXtreme\Parser\BaseParser;

class FixedCostParser extends BaseParser
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
            'name' => $data->name,
            'description' => $data->description,
            'amount' => $data->amount,
            'frequency' => $data->frequency,
        ];
    }

}
