<?php

namespace Database\Seeders\Setting;

use App\Models\Setting\Setting;
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
        return array(
            [
                'key' => 'tax',
                'description' => 'Tax percentage',
                'value' => '0.12',
            ],
            [
                'key' => 'profitMargin',
                'description' => 'Profit margin percentage',
                'value' => '0.30',
            ]
        );
    }

}
