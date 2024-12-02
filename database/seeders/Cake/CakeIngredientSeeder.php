<?php

namespace Database\Seeders\Cake;

use App\Models\Cake\CakeComponentIngredient;
use App\Services\Constant\Cake\CakeIngredientUnit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CakeIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getData();

        foreach ($data as $item) {
            CakeComponentIngredient::create($item);
        }
    }

    /** --- FUNCTIONS --- */
    private function getData()
    {
        return [
            [
                'name' => 'Flour',
                'unitId' => CakeIngredientUnit::GRAM_ID,
                'price' => 14,
                'expirationDate' => Carbon::parse('2025-11-13'),
                'quantity' => 100000,
                'supplier' => 'PT. Tepung',
            ],
            [
                'name' => 'Sugar',
                'unitId' => CakeIngredientUnit::GRAM_ID,
                'price' => 10,
                'expirationDate' => Carbon::parse('2025-11-13'),
                'quantity' => 30000,
                'supplier' => 'PT. Gula',
            ],
            [
                'name' => 'Egg',
                'unitId' => CakeIngredientUnit::PIECE_ID,
                'price' => 2000,
                'expirationDate' => Carbon::parse('2025-11-13'),
                'quantity' => 50,
                'supplier' => 'PT. Telur',
            ],
            [
                'name' => 'Milk',
                'unitId' => CakeIngredientUnit::LITER_ID,
                'price' => 6000,
                'expirationDate' => Carbon::parse('2025-11-13'),
                'quantity' => 30,
                'supplier' => 'PT. Susu',
            ],
        ];
    }
}
