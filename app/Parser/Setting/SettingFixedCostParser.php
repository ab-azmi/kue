<?php

namespace App\Parser\Setting;

use App\Services\Constant\Setting\FrequencyConstant;
use GlobalXtreme\Parser\BaseParser;

class SettingFixedCostParser extends BaseParser
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
            'name' => $data->name,
            'description' => $data->description,
            'amount' => $data->amount,
            'frequency' => FrequencyConstant::idName($data->frequencyId),
            'createdAt' => $data->createdAt->format('d/m/Y H:i'),
            'updatedAt' => $data->updatedAt->format('d/m/Y H:i'),
        ];
    }
}
