<?php

namespace App\Parser\Employee;

use GlobalXtreme\Parser\BaseParser;

class EmployeeParser extends BaseParser
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
            'userId' => $data->userId,
            'address' => $data->address,
            'phone' => $data->phone,
            'bankNumber' => $data->bankNumber,
            'createdAt' => $data->created_at,
            'updatedAt' => $data->updated_at,
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
            'userId' => $data->userId,
            'address' => $data->address,
            'phone' => $data->phone,
            'bankNumber' => $data->bankNumber,
            'createdAt' => $data->created_at,
            'updatedAt' => $data->updated_at,
        ];
    }

}
