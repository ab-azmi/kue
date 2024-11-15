<?php

namespace App\Parser\User;

use App\Parser\Salary\SalaryParser;
use GlobalXtreme\Parser\BaseParser;

class UserParser extends BaseParser
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
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'salary' => SalaryParser::brief($data->salary),
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
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
        ];
    }

}
