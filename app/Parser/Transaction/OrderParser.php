<?php

namespace App\Parser\Transaction;

use App\Models\Cake\CakeVariant;
use App\Parser\Cake\CakeVariantParser;
use GlobalXtreme\Parser\BaseParser;

class OrderParser extends BaseParser
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
            'price' => $data->price,
            'totalPrice' => $data->totalPrice,
            'quantity' => $data->quantity,
            'discount' => $data->discount,
            'transactionId' => $data->transactionId,
            'cakeVariantId' => $data->cakeVariantId,
            'createdAt' => $data->createdAt->format('m/d/Y H:i'),
            'updatedAt' => $data->updatedAt?->format('m/d/Y H:i'),
            'deletedAt' => $data->deletedAt?->format('m/d/Y H:i'),
            'cakeVariant' => CakeVariantParser::first($data->cakeVariant)
        ];
    }

    public static function brief($data)
    {
        if (!$data) {
            return null;
        }

        return [
            'price' => $data->price,
            'totalPrice' => $data->totalPrice,
            'quantity' => $data->quantity,
            'discount' => $data->discount,
            'transactionId' => $data->transactionId,
            'cakeVariantId' => $data->cakeVariantId,
            'createdAt' => $data->createdAt->format('m/d/Y H:i'),
            'updatedAt' => $data->updatedAt?->format('m/d/Y H:i'),
            'deletedAt' => $data->deletedAt?->format('m/d/Y H:i'),
        ];
    }

}
