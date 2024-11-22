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
        $data = $this->getData();

        foreach ($data as $item) {
            $cake = Cake::create([
                'name' => $item['name'],
                'profitMargin' => $item['profitMargin'],
                'COGS' => $item['COGS'],
                'stock' => $item['stock'],
                'sellingPrice' => $item['sellingPrice'],
                'images' => $item['images'],
            ]);
            
            foreach (CakeComponentIngredient::all()->random(3) as $ingredient) {
                $cake->ingredients()->attach($ingredient->id, [
                    'quantity' => rand(1, 5)
                ]);
            }
            $cake->variants()->createMany($item['variants']);
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
                'profitMargin' => 0.5,
                'COGS' => 100000,
                'stock' => 10,
                'sellingPrice' => 150000,
                'images' => json_encode([
                    'https://via.placeholder.com/150',
                    'https://via.placeholder.com/150',
                ]),
                'variants' => [
                    [
                        'name' => 'Polar Bear Cake - Medium',
                        'price' => 50000,
                        'description' => 'Polar Bear Cake - Variant 1 Description',
                    ],
                    [
                        'name' => 'Polar Bear Cake - Party',
                        'price' => 100000,
                        'description' => 'Polar Bear Cake - Variant 2 Description',
                    ],
                ]
            ],
            [
                'name' => 'Panda Cake',
                'profitMargin' => null,
                'COGS' => 400000,
                'stock' => 15,
                'sellingPrice' => 600000,
                'images' => json_encode([
                    'https://via.placeholder.com/150',
                    'https://via.placeholder.com/150',
                ]),
                'variants' => [
                    [
                        'name' => 'Panda Cake - Chocolate',
                        'price' => 200000,
                        'description' => 'Panda Cake - Variant 1 Description',
                    ],
                    [
                        'name' => 'Panda Cake - Vanilla',
                        'price' => 400000,
                        'description' => 'Panda Cake - Variant 2 Description',
                    ],
                ]
            ]
        );
    }

}
