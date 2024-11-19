<?php

namespace App\Parser\Employee;

use App\Parser\Salary\EmployeeSalaryParser;
use GlobalXtreme\Parser\BaseParser;

class EmployeeUserParser extends BaseParser
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
            'email' => $data->email,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
            'salary' => EmployeeSalaryParser::brief($data->salary),
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
            'email' => $data->email,
            'createdAt' => $data->createdAt,
            'updatedAt' => $data->updatedAt,
        ];
    }

}
