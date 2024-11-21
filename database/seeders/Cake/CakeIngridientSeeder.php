<?php

namespace Database\Seeders\Cake;

use App\Models\Cake\CakeComponentIngridient;
use App\Services\Constant\Cake\CakeIngridientUnit;
use Illuminate\Database\Seeder;

class CakeIngridientSeeder extends Seeder
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
                'unitId' => CakeIngridientUnit::KILOGRAM_ID,
                'price' => '10000',
                'expirationDate' => '2025-11-13',
                'quantity' => '100',
                'supplier' => 'PT. Tepung',
            ],
            [
                'name' => 'Sugar',
                'unitId' => CakeIngridientUnit::KILOGRAM_ID,
                'price' => '15000',
                'expirationDate' => '2025-11-13',
                'quantity' => '70',
                'supplier' => 'PT. Gula',
            ],
            [
                'name' => 'Egg',
                'unitId' => CakeIngridientUnit::PIECE_ID,
                'price' => '2000',
                'expirationDate' => '2025-11-13',
                'quantity' => '50',
                'supplier' => 'PT. Telur',
            ],
            [
                'name' => 'Milk',
                'unitId' => CakeIngridientUnit::LITER_ID,
                'price' => '20000',
                'expirationDate' => '2025-11-13',
                'quantity' => '30',
                'supplier' => 'PT. Susu',
            ]
        );
    }

}
