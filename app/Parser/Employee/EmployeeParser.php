<?php

namespace App\Parser\Employee;

use GlobalXtreme\Parser\BaseParser;

class EmployeeParser extends BaseParser
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
            'userId' => $data->userId,
            'address' => $data->address,
            'phone' => $data->phone,
            'bankNumber' => $data->bankNumber,
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
            'user' => EmployeeUserParser::brief($data->user),
            'salary' => EmployeeSalaryParser::brief($data->salary),
        ];
    }

    public static function brief($data)
    {
        if (! $data) {
            return null;
        }

        return [
            'id' => $data->id,
            'userId' => $data->userId,
            'address' => $data->address,
            'phone' => $data->phone,
            'bankNumber' => $data->bankNumber,
            'user' => EmployeeUserParser::brief($data->user),
        ];
    }
}
