<?php

namespace App\Parser\Salary;

use App\Parser\User\UserParser;
use GlobalXtreme\Parser\BaseParser;

class SalaryParser extends BaseParser
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
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'user' => UserParser::brief($data->user),
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
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
        ];
    }

}
