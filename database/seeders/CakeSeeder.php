<?php

namespace Database\Seeders;

use App\Models\v1\Cake\Cake;
use App\Models\v1\Cake\CakeIngridient;
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

        DB::table('cake_variants')->insert(
            ['name' => 'Vanilla'],
            ['name' => 'Mango'],
            ['name' => 'Durian'],
        );


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
    }


    /** --- FUNCTIONS --- */

    private function getData()
    {
        return array(
            [
                'name' => 'Polar Bear Cake',
                'cake_variant_id' => CakeVariant::all()->random()->id,
                'profit_margin' => '0.5',
                'cogs' => '100000',
                'sell_price' => '150000',
                'images' => json_encode([
                    'https://via.placeholder.com/150',
                    'https://via.placeholder.com/150',
                ]),
            ],
            [
                'name' => 'Panda Cake',
                'cake_variant_id' => CakeVariant::all()->random()->id,
                'profit_margin' => null,
                'cogs' => '400000',
                'sell_price' => '600000',
                'images' => json_encode([
                    'https://via.placeholder.com/150',
                    'https://via.placeholder.com/150',
                ]),
            ]
        );
    }

}
