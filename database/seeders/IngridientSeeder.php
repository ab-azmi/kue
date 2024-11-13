<?php

namespace Database\Seeders;

use App\Models\v1\Ingridient\Ingridient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngridientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getData();

        foreach ($data as $item) {
            Ingridient::create($item);
        }
    }


    /** --- FUNCTIONS --- */

    private function getData()
    {
        return array(
            [
                'name' => 'Flour',
                'unit' => 'kg',
                'price_per_unit' => '10000',
                'expiration_date' => '2025-11-13',
                'quantity' => '100',
                'supplier' => 'PT. Tepung',
            ],
            [
                'name' => 'Sugar',
                'unit' => 'kg',
                'price_per_unit' => '15000',
                'expiration_date' => '2025-11-13',
                'quantity' => '70',
                'supplier' => 'PT. Gula',
            ],
            [
                'name' => 'Egg',
                'unit' => 'pcs',
                'price_per_unit' => '2000',
                'expiration_date' => '2025-11-13',
                'quantity' => '50',
                'supplier' => 'PT. Telur',
            ],
            [
                'name' => 'Milk',
                'unit' => 'L',
                'price_per_unit' => '20000',
                'expiration_date' => '2025-11-13',
                'quantity' => '30',
                'supplier' => 'PT. Susu',
            ]
        );
    }

}
