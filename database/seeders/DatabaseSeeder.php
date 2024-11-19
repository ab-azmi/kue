<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Cake\CakeSeeder;
use Database\Seeders\Employee\UserSeeder;
use Database\Seeders\Ingridient\IngridientSeeder;
use Database\Seeders\Setting\FixedCostSeeder;
use Database\Seeders\Setting\SettingSeeder;
use Database\Seeders\Transaction\TransactionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            IngridientSeeder::class,
            CakeSeeder::class,
            FixedCostSeeder::class,
            TransactionSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
