<?php

namespace Database\Seeders\Transaction;

use App\Models\Transaction\Transaction;
use App\Services\Constant\Transaction\TransactionStatusConstant;
use App\Services\Number\Generator\TransactionNumber;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = Transaction::factory(100)->create();
        $data->each(function ($item) {
            $item->orders()->createMany([
                [
                    'price' => 10000,
                    'quantity' => 1,
                    'discount' => null,
                    'cakeVariantId' => 1,
                ],
                [
                    'price' => 4000,
                    'quantity' => 1,
                    'discount' => null,
                    'cakeVariantId' => 3,
                ],
            ]);
        });
    }

    /** --- FUNCTIONS --- */
    private function getData()
    {
        return [
            [
                'quantity' => 1,
                'number' => TransactionNumber::generate(),
                'statusId' => TransactionStatusConstant::SUCCESS_ID,
                'tax' => 6000,
                'orderPrice' => 14000,
                'totalPrice' => 17000,
                'totalDiscount' => null,
                'employeeId' => 1,
            ],
        ];
    }
}
