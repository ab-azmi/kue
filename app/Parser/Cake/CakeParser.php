<?php

namespace App\Parser\Cake;

use App\Parser\Ingridient\IngridientParser;
use App\Parser\Setting\CakeVariantParser;
use GlobalXtreme\Parser\BaseParser;

class CakeParser extends BaseParser
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
            'profitMargin' => $data->profitMargin,
            'cogs' => $data->cogs,
            'sellPrice' => $data->sellPrice,
            'images' => $data->images,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
            'ingridients' => IngridientParser::brief($data->ingridients),
            'variant' => CakeVariantParser::brief($data->variant),
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
            'profitMargin' => $data->profitMargin,
            'cogs' => $data->cogs,
            'sellPrice' => $data->sellPrice,
            'images' => $data->images,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
        ];
    }

}
