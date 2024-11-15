<?php

namespace Database\Seeders;

use App\Models\v1\Cake\Cake;
use App\Models\v1\Cake\CakeIngridient;
use App\Models\v1\Cake\Discount;
use App\Models\v1\Ingridient\Ingridient;
use App\Models\v1\Setting\CakeVariant;
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
            foreach (Ingridient::all()->random(3) as $ingridient) {
                $cake->ingridients()->attach($ingridient->id, [
                    'quantity' => rand(1, 5),
                    'unit' => $ingridient->unit,
                ]);
            }
        }

        DB::table('discounts')->insert([
            [
                'name' => 'Discount 1',
                'description' => 'Discount 1 Description',
                'start_date' => '2021-01-01',
                'end_date' => '2021-12-31',
                'value' => '10000',
                'cakeId' => Cake::all()->random()->id,
            ],
            [
                'name' => 'Discount 2',
                'description' => 'Discount 2 Description',
                'start_date' => '2021-01-01',
                'end_date' => '2021-12-31',
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
                'cogs' => '100000',
                'sellPrice' => '150000',
                'images' => json_encode([
                    'https://via.placeholder.com/150',
                    'https://via.placeholder.com/150',
                ]),
            ],
            [
                'name' => 'Panda Cake',
                'cakeVariantId' => CakeVariant::all()->random()->id,
                'profitMargin' => null,
                'cogs' => '400000',
                'sellPrice' => '600000',
                'images' => json_encode([
                    'https://via.placeholder.com/150',
                    'https://via.placeholder.com/150',
                ]),
            ]
        );
    }

}
