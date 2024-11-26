<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Cake\CakeIngredientSeeder;
use Database\Seeders\Cake\CakeSeeder;
use Database\Seeders\Employee\EmployeeSeeder;
use Database\Seeders\Setting\SettingFixedCostSeeder;
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
            EmployeeSeeder::class,
            CakeIngredientSeeder::class,
            CakeSeeder::class,
            TransactionSeeder::class,
            SettingSeeder::class,
            SettingFixedCostSeeder::class,
        ]);
    }
}
