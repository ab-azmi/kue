<?php

namespace Database\Seeders\Cake;

use App\Models\Cake\Cake;
use App\Models\Cake\CakeComponentIngredient;
use App\Models\Cake\CakeVariant;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        DB::table('cake_variants')->insert([
            ['name' => 'Vanilla', 'price' => 100000],
            ['name' => 'Chocolate', 'price' => 150000],
            ['name' => 'Strawberry', 'price' => 200000],
            ['name' => 'Blueberry', 'price' => 250000],
        ]);


        $data = $this->getData();

        foreach ($data as $item) {
            $cake = Cake::create($item);
            // Attach random ingredients
            foreach (CakeComponentIngredient::all()->random(3) as $ingredient) {
                $cake->ingredients()->attach($ingredient->id, [
                    'quantity' => rand(1, 5)
                ]);
            }
        }

        DB::table('cake_discounts')->insert([
            [
                'name' => 'Discount 1',
                'description' => 'Discount 1 Description',
                'fromDate' => Carbon::parse('2021-01-01'),
                'toDate' => Carbon::parse('2021-12-31'),
                'value' => 10000,
                'cakeId' => Cake::all()->random()->id,
            ],
            [
                'name' => 'Discount 2',
                'description' => 'Discount 2 Description',
                'fromDate' => Carbon::parse('2021-01-01'),
                'toDate' => Carbon::parse('2021-12-31'),
                'value' => 20000,
                'cakeId' => Cake::all()->random()->id,
            ],
        ]);
    }


    /** --- FUNCTIONS --- */

    private function getData()
    {
        return array(
            [
                'name' => 'Polar Bear Cake',
                'cakeVariantId' => CakeVariant::all()->random()->id,
                'profitMargin' => 0.5,
                'COGS' => 100000,
                'stock' => 10,
                'sellingPrice' => 150000,
                'images' => json_encode([
                    'https://via.placeholder.com/150',
                    'https://via.placeholder.com/150',
                ]),
            ],
            [
                'name' => 'Panda Cake',
                'cakeVariantId' => CakeVariant::all()->random()->id,
                'profitMargin' => null,
                'COGS' => 400000,
                'stock' => 15,
                'sellingPrice' => 600000,
                'images' => json_encode([
                    'https://via.placeholder.com/150',
                    'https://via.placeholder.com/150',
                ]),
            ]
        );
    }

}
