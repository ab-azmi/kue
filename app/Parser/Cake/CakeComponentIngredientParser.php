<?php

namespace App\Parser\Cake;

use App\Services\Constant\Cake\CakeIngredientUnit;
use GlobalXtreme\Parser\BaseParser;

class CakeComponentIngredientParser extends BaseParser
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
            'unit' => CakeIngredientUnit::idName($data->unitId),
            'price' => $data->price,
            'expirationDate' => $data->expirationDate->format('d/m/Y H:i'),
            'quantity' => $data->quantity,
            'supplier' => $data->supplier,
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
            'cakes' => CakeParser::briefs($data->cakes),
            'pivot' => $data->pivot,
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
            'unit' => CakeIngredientUnit::idName($data->unitId),
            'price' => $data->price,
            'expirationDate' => $data->expirationDate->format('d/m/Y H:i'),
            'quantity' => $data->quantity,
            'supplier' => $data->supplier,
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
            'pivot' => $data->pivot,
        ];
    }
}
