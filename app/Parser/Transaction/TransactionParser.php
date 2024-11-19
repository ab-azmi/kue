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
            'code' => $data->code,
            'tax' => $data->tax,
            'orderPrice' => $data->orderPrice,
            'totalPrice' => $data->totalPrice, 
            'totalDiscount' => $data->totalDiscount,
            'employeeId' => $data->employeeId,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
            'deletedAt' => $data->deletedAt,
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
            'code' => $data->code,
            'tax' => $data->tax,
            'orderPrice' => $data->orderPrice,
            'totalPrice' => $data->totalPrice, 
            'totalDiscount' => $data->totalDiscount,
            'employeeId' => $data->employeeId,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
            'deletedAt' => $data->deletedAt,
        ];
    }

}
