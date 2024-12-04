<?php

namespace App\Parser\Transaction;

use App\Parser\Employee\EmployeeParser;
use App\Parser\Employee\EmployeeUserParser;
use App\Services\Constant\Transaction\TransactionStatusConstant;
use GlobalXtreme\Parser\BaseParser;

class TransactionParser extends BaseParser
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
            'status' => TransactionStatusConstant::idName($data->statusId),
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
            'employee' => EmployeeParser::brief($data->employee),
            'orders' => TransactionOrderParser::get($data->orders),
        ];
    }

    public static function brief($data)
    {
        if (! $data) {
            return null;
        }

        return [
            'id' => $data->id,
            'status' => TransactionStatusConstant::idName($data->statusId),
            'quantity' => $data->quantity,
            'number' => $data->number,
            'tax' => $data->tax,
            'orderPrice' => $data->orderPrice,
            'totalPrice' => $data->totalPrice,
            'totalDiscount' => $data->totalDiscount,
            'employeeId' => $data->employeeId,
            'employee' => EmployeeParser::brief($data->employee),
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt?->format('d/m/Y H:i'),
            'deletedAt' => $data->deletedAt?->format('d/m/Y H:i'),
        ];
    }
}
