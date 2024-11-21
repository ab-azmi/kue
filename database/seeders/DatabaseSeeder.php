<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Cake\CakeSeeder;
use Database\Seeders\Cake\CakeIngridientSeeder;
use Database\Seeders\Employee\EmployeeSeeder;
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
            EmployeeSeeder::class,
            CakeIngridientSeeder::class,
            CakeSeeder::class,
            FixedCostSeeder::class,
            TransactionSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
