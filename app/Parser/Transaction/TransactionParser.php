<?php

namespace App\Parser\Transaction;

use App\Parser\User\UserParser;
use GlobalXtreme\Parser\BaseParser;

class TransactionParser extends BaseParser
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
            'quantity' => $data->quantity,
            'customerName' => $data->customerName,
            'tax' => $data->tax,
            'orderPrice' => $data->orderPrice,
            'totalPrice' => $data->totalPrice, 
            'totalDiscount' => $data->totalDiscount,
            'cashierId' => $data->cashierId,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
            'deletedAt' => $data->deletedAt,
            'cashier' => UserParser::brief($data->cashier),
            'orders' => OrderParser::get($data->orders)
        ];
    }

    public static function brief($data){
        if (!$data) {
            return null;
        }

        return [
            'id' => $data->id,
            'quantity' => $data->quantity,
            'customerName' => $data->customerName,
            'tax' => $data->tax,
            'orderPrice' => $data->orderPrice,
            'totalPrice' => $data->totalPrice, 
            'totalDiscount' => $data->totalDiscount,
            'cashierId' => $data->cashierId,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
            'deletedAt' => $data->deletedAt,
        ];
    }

}
