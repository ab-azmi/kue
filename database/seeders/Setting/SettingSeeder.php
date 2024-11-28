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
                'value' => 0.12,
            ],
            [
                'key' => SettingConstant::PROFIT_MARGIN_KEY,
                'description' => 'Profit margin percentage',
                'value' => 3,
            ]
        ];
    }
}
