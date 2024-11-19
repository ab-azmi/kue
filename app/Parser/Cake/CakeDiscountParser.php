<?php

namespace App\Parser\Cake;

use GlobalXtreme\Parser\BaseParser;

class CakeDiscountParser extends BaseParser
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
            'fromDate' => $data->fromDate->format('d/m/Y'),
            'toDate' => $data->toDate->format('d/m/Y'),
            'value' => $data->value,
            'cakeId' => $data->cake_id,
            'createdAt' => $data->created_at?->format('d/m/Y H:i'),
            'updatedAt' => $data->updated_at?->format('d/m/Y H:i'),
            'cake' => CakeParser::brief($data->cake),
        ];
    }

    public static function brief($data)
    {
        if (!$data) {
            return null;
        }

        return [
            'id' => $data->id,
            'name' => $data->name,
            'description' => $data->description,
            'fromDate' => $data->fromDate->format('d/m/Y'),
            'toDate' => $data->toDate->format('d/m/Y'),
            'value' => $data->value,
            'cakeId' => $data->cake_id,
            'createdAt' => $data->created_at?->format('d/m/Y H:i'),
            'updatedAt' => $data->updated_at?->format('d/m/Y H:i'),
        ];
    }

}
