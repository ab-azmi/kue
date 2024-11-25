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
                'unitId' => CakeIngredientUnit::KILOGRAM_ID,
                'price' => 10000,
                'expirationDate' => Carbon::parse('2025-11-13'),
                'quantity' => 100,
                'supplier' => 'PT. Tepung',
            ],
            [
                'name' => 'Sugar',
                'unitId' => CakeIngredientUnit::KILOGRAM_ID,
                'price' => 15000,
                'expirationDate' => Carbon::parse('2025-11-13'),
                'quantity' => 70,
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
                'price' => 20000,
                'expirationDate' => Carbon::parse('2025-11-13'),
                'quantity' => 30,
                'supplier' => 'PT. Susu',
            ],
        ];
    }
}
