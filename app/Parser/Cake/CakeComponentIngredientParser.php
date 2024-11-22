<?php

namespace App\Parser\Cake;
use GlobalXtreme\Parser\BaseParser;

class CakeComponentIngredientParser extends BaseParser
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
            'unitId' => $data->unitId,
            'price' => $data->price,
            'expirationDate' => $data->expirationDate,
            'quantity' => $data->quantity,
            'supplier' => $data->supplier,
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
            'used' => $data->used,
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
            'unitId' => $data->unitId,
            'price' => $data->price,
            'expirationDate' => $data->expirationDate,
            'quantity' => $data->quantity,
            'supplier' => $data->supplier,
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
        ];
    }

    

}
