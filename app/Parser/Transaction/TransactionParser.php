<?php

namespace App\Parser\Transaction;

use App\Parser\Employee\EmployeeUserParser;
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
            'number' => $data->number,
            'tax' => $data->tax,
            'orderPrice' => $data->orderPrice,
            'totalPrice' => $data->totalPrice, 
            'totalDiscount' => $data->totalDiscount,
            'employeeId' => $data->employeeId,
            'createdAt' => $data->createdAt->format('m/d/Y H:i'),
            'updatedAt' => $data->updatedAt?->format('m/d/Y H:i'),
            'deletedAt' => $data->deletedAt?->format('m/d/Y H:i'),
            'employee' => EmployeeUserParser::brief($data->employee),
            'orders' => OrderParser::briefs($data->orders)
        ];
    }

    public static function brief($data){
        if (!$data) {
            return null;
        }

        return [
            'id' => $data->id,
            'quantity' => $data->quantity,
            'number' => $data->number,
            'tax' => $data->tax,
            'orderPrice' => $data->orderPrice,
            'totalPrice' => $data->totalPrice, 
            'totalDiscount' => $data->totalDiscount,
            'employeeId' => $data->employeeId,
            'createdAt' => $data->createdAt->format('m/d/Y H:i'),
            'updatedAt' => $data->updatedAt?->format('m/d/Y H:i'),
            'deletedAt' => $data->deletedAt?->format('m/d/Y H:i'),
        ];
    }

}
