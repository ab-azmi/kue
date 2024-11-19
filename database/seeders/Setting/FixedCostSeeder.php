<?php

namespace Database\Seeders\Setting;

use App\Models\Setting\SettingFixedCost;
use App\Services\Constant\Setting\FrequencyConstant;
use Illuminate\Database\Seeder;

class FixedCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getData();
        foreach ($data as $item) {
            SettingFixedCost::create($item);
        }
    }


    /** --- FUNCTIONS --- */

    private function getData()
    {
        return array(
            [
                'name' => 'Rent',
                'description' => 'Monthly rent',
                'amount' => '5000000',
                'frequency' => FrequencyConstant::MONTHLY_ID,
            ],
            [
                'name' => 'Electricity',
                'description' => 'Monthly electricity bill',
                'amount' => '300000',
                'frequency' => FrequencyConstant::MONTHLY_ID,
            ],
            [
                'name' => 'Water',
                'description' => 'Monthly water bill',
                'amount' => '100000',
                'frequency' => FrequencyConstant::MONTHLY_ID,
            ]
        );
    }

}
