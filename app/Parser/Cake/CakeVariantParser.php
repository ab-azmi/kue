<?php

namespace App\Parser\Cake;

use GlobalXtreme\Parser\BaseParser;

class CakeVariantParser extends BaseParser
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
            'cakeId' => $data->cakeId,
            'name' => $data->name,
            'price' => $data->price,
            'createdAt' => $data->createdAt?->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt?->format('d/m/Y H:i'),
            'cake' => CakeParser::brief($data->cake),
        ];
    }
}
