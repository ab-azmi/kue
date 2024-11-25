<?php

namespace App\Parser\Cake;

use GlobalXtreme\Parser\BaseParser;

class CakeDiscountParser extends BaseParser
{
    /**
     * @return array|null
     */
    public static function first($data)
    {
        if (! $data) {
            return null;
        }

        return [
            'id' => $data->id,
            'name' => $data->name,
            'description' => $data->description,
            'fromDate' => $data->fromDate->format('d/m/Y H:i'),
            'toDate' => $data->toDate->format('d/m/Y H:i'),
            'value' => $data->value,
            'cakeId' => $data->cake_id,
            'createdAt' => $data->createdAt?->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt?->format('d/m/Y H:i'),
            'deletedAt' => $data->deletedAt?->format('d/m/Y H:i'),
            'cake' => CakeParser::brief($data->cake),
        ];
    }

    public static function brief($data)
    {
        if (! $data) {
            return null;
        }

        return [
            'id' => $data->id,
            'name' => $data->name,
            'description' => $data->description,
            'fromDate' => $data->fromDate->format('d/m/Y H:i'),
            'toDate' => $data->toDate->format('d/m/Y H:i'),
            'value' => $data->value,
            'cakeId' => $data->cake_id,
            'createdAt' => $data->createdAt?->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt?->format('d/m/Y H:i'),
            'deletedAt' => $data->deletedAt?->format('d/m/Y H:i'),
        ];
    }
}
