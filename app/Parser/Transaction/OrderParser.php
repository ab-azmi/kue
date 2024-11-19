<?php

namespace App\Parser\Transaction;

use App\Parser\Cake\CakeParser;
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
            'cakeId' => $data->cakeId,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
            'deletedAt' => $data->deletedAt,
            'transaction' => TransactionParser::brief($data->transaction),
            'cake' => CakeParser::brief($data->cake)
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
            'cakeId' => $data->cakeId,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
            'deletedAt' => $data->deletedAt,
        ];
    }

}
