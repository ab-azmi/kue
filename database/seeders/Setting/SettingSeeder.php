<?php

namespace Database\Seeders\Setting;

use App\Models\Setting\Setting;
use App\Services\Constant\Setting\SettingConstant;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getData();

        foreach ($data as $setting) {
            Setting::create($setting);
        }
    }

    /** --- FUNCTIONS --- */
    private function getData()
    {
        return [
            [
                'key' => SettingConstant::TAX_KEY,
                'description' => 'Tax percentage',
                'value' => 12,
            ],
            [
                'key' => SettingConstant::PROFIT_MARGIN_KEY,
                'description' => 'Profit margin percentage',
                'value' => 3,
            ],
            [
                'key' => SettingConstant::SALARY_TO_CAKE_PERCENTAGE_KEY,
                'description' => 'Salary to cake price percentage',
                'value' => 10,
            ],
            [
                'key' => SettingConstant::FIXED_COST_TO_CAKE_PERCENTAGE_KEY,
                'description' => 'Fixed cost to cake price percentage',
                'value' => 1.2,
            ],
        ];
    }
}
