<?php

namespace App\Parser\Employee;

use App\Parser\Employee\EmployeeUserParser;
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
            'total_salary' => $data->total_salary,
            'created_at' => $data->createdAt->format('d/m/Y H:i'),
            'updated_at' => $data->updatedAt->format('d/m/Y H:i'),
            'user' => EmployeeUserParser::brief($data->user),
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
            'total_salary' => $data->total_salary,
            'created_at' => $data->createdAt->format('d/m/Y H:i'),
            'updated_at' => $data->updatedAt->format('d/m/Y H:i'),
        ];
    }

}
