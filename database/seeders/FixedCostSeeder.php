<?php

namespace Database\Seeders;

use App\Models\Setting\FixedCost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            FixedCost::create($item);
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
                'frequency' => 'monthly',
            ],
            [
                'name' => 'Electricity',
                'description' => 'Monthly electricity bill',
                'amount' => '300000',
                'frequency' => 'monthly',
            ],
            [
                'name' => 'Water',
                'description' => 'Monthly water bill',
                'amount' => '100000',
                'frequency' => 'monthly',
            ]
        );
    }

}
