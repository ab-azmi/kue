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
            'createdAt' => $data->createdAt->format('m/d/Y H:i'),
            'updatedAt' => $data->updatedAt->format('m/d/Y H:i'),
            'deletedAt' => $data->deletedAt->format('m/d/Y H:i'),
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
            'createdAt' => $data->createdAt->format('m/d/Y H:i'),
            'updatedAt' => $data->updatedAt->format('m/d/Y H:i'),
            'deletedAt' => $data->deletedAt->format('m/d/Y H:i'),
        ];
    }

}
