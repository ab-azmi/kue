<?php

namespace Database\Seeders\Cake;

use App\Models\Cake\CakeComponentIngridient;
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
            CakeComponentIngridient::create($item);
        }
    }


    /** --- FUNCTIONS --- */

    private function getData()
    {
        return array(
            [
                'name' => 'Flour',
                'unit' => 'kg',
                'pricePerUnit' => '10000',
                'expirationDate' => '2025-11-13',
                'quantity' => '100',
                'supplier' => 'PT. Tepung',
            ],
            [
                'name' => 'Sugar',
                'unit' => 'kg',
                'pricePerUnit' => '15000',
                'expirationDate' => '2025-11-13',
                'quantity' => '70',
                'supplier' => 'PT. Gula',
            ],
            [
                'name' => 'Egg',
                'unit' => 'pcs',
                'pricePerUnit' => '2000',
                'expirationDate' => '2025-11-13',
                'quantity' => '50',
                'supplier' => 'PT. Telur',
            ],
            [
                'name' => 'Milk',
                'unit' => 'L',
                'pricePerUnit' => '20000',
                'expirationDate' => '2025-11-13',
                'quantity' => '30',
                'supplier' => 'PT. Susu',
            ]
        );
    }

}
