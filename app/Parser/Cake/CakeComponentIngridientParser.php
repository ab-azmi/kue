<?php

namespace App\Parser\Cake;
use GlobalXtreme\Parser\BaseParser;

class CakeComponentIngridientParser extends BaseParser
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
            'unit' => $data->unit,
            'pricePerUnit' => $data->pricePerUnit,
            'expirationDate' => $data->expirationDate,
            'quantity' => $data->quantity,
            'supplier' => $data->supplier,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
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
            'unit' => $data->unit,
            'pricePerUnit' => $data->pricePerUnit,
            'expirationDate' => $data->expirationDate,
            'quantity' => $data->quantity,
            'supplier' => $data->supplier,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
        ];
    }

    

}