<?php

namespace App\Parser\Ingridient;

use App\Parser\Cake\CakeParser;
use GlobalXtreme\Parser\BaseParser;

class IngridientParser extends BaseParser
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
