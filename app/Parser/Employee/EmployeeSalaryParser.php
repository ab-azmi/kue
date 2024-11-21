<?php

namespace App\Parser\Employee;

use App\Parser\Employee\EmployeeParser;
use GlobalXtreme\Parser\BaseParser;

class EmployeeSalaryParser extends BaseParser
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
            'basic_salary' => $data->basic_salary,
            'tax' => $data->tax,
            'overtime' => $data->overtime,
            'totalSalary' => $data->totalSalary,
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
            'employee' => EmployeeParser::brief($data->employee),
        ];
    }

    public static function brief($data)
    {
        if (!$data) {
            return null;
        }

        return [
            'id' => $data->id,
            'basic_salary' => $data->basic_salary,
            'tax' => $data->tax,
            'overtime' => $data->overtime,
            'totalSalary' => $data->totalSalary,
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
        ];
    }

}
