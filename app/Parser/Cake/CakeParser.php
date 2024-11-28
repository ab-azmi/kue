<?php

namespace App\Parser\Cake;

use App\Models\Cake\Cake;
use GlobalXtreme\Parser\BaseParser;

class CakeParser extends BaseParser
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
            'profitMargin' => $data->profitMargin,
            'COGS' => $data->cogs,
            'sellingPrice' => $data->sellingPrice,
            'stock' => $data->stock,
            'images' => $data->getImageLinks(),
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
            'ingredients' => CakeComponentIngredientParser::briefs($data->getComponentIngredients()),
            'variants' => CakeVariantParser::briefs($data->variants),
            'discounts' => CakeDiscountParser::briefs($data->discounts),
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
