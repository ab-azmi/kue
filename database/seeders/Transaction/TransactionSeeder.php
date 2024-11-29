<?php

namespace Database\Seeders\Transaction;

use App\Models\Transaction\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getData();
        Transaction::create($data[0])->orders()->createMany([
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
    }

    /** --- FUNCTIONS --- */
    private function getData()
    {
        return [
            [
                'quantity' => 1,
                'number' => 'TSX34634534',
                'tax' => 6000,
                'orderPrice' => 14000,
                'totalPrice' => 17000,
                'totalDiscount' => null,
                'employeeId' => 1,
            ],
        ];
    }
}
