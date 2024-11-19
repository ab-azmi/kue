<?php

namespace App\Parser\Cake;

use App\Parser\Cake\CakeComponentIngridientParser;
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
            'COGS' => $data->cogs,
            'sellingPrice' => $data->sellingPrice,
            'stock' => $data->stock,
            'images' => $data->images,
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
            'ingridients' => CakeComponentIngridientParser::get($data->ingridients),
            'variant' => CakeVariantParser::first($data->variant),
            'discounts' => CakeDiscountParser::get($data->discount),
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
            'COGS' => $data->cogs,
            'sellingPrice' => $data->sellingPrice,
            'stock' => $data->stock,
            'images' => $data->images,
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
        ];
    }

}
