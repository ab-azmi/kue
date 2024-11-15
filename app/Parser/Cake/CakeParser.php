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
            'stock' => $data->stock,
            'images' => $data->images,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
            'ingridients' => IngridientParser::get($data->ingridients),
            'variant' => CakeVariantParser::first($data->variant),
            'discounts' => DiscountParser::get($data->discount),
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
            'stock' => $data->stock,
            'images' => $data->images,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
        ];
    }

}
