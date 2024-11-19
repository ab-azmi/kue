<?php

namespace Database\Seeders\Cake;

use App\Models\Cake\Cake;
use App\Models\Cake\CakeComponentIngridient;
use App\Models\Cake\CakeVariant;
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
            ['name' => 'Vanilla'],
            ['name' => 'Mango'],
            ['name' => 'Durian'],
            ['name' => 'Chocolate'],
            ['name' => 'Strawberry'],
            ['name' => 'Blueberry'],
        ]);


        $data = $this->getData();

        foreach ($data as $item) {
            $cake = Cake::create($item);
            // Attach random ingridients
            foreach (CakeComponentIngridient::all()->random(3) as $ingridient) {
                $cake->ingridients()->attach($ingridient->id, [
                    'quantity' => rand(1, 5),
                    'unit' => $ingridient->unit,
                ]);
            }
        }

        DB::table('cake_discounts')->insert([
            [
                'name' => 'Discount 1',
                'description' => 'Discount 1 Description',
                'fromDate' => '2021-01-01',
                'toDate' => '2021-12-31',
                'value' => '10000',
                'cakeId' => Cake::all()->random()->id,
            ],
            [
                'name' => 'Discount 2',
                'description' => 'Discount 2 Description',
                'fromDate' => '2021-01-01',
                'toDate' => '2021-12-31',
                'value' => '20000',
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
                'profitMargin' => '0.5',
                'COGS' => '100000',
                'stock' => '10',
                'sellingPrice' => '150000',
                'images' => json_encode([
                    'https://via.placeholder.com/150',
                    'https://via.placeholder.com/150',
                ]),
            ],
            [
                'name' => 'Panda Cake',
                'cakeVariantId' => CakeVariant::all()->random()->id,
                'profitMargin' => null,
                'COGS' => '400000',
                'stock' => '15',
                'sellingPrice' => '600000',
                'images' => json_encode([
                    'https://via.placeholder.com/150',
                    'https://via.placeholder.com/150',
                ]),
            ]
        );
    }

}
