<?php

namespace Database\Seeders\Transaction;

use App\Models\Transaction\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'cakeId' => 1,
            ],
            [
                'price' => 4000,
                'quantity' => 1,
                'discount' => null,
                'cakeId' => 2,
            ]
        ]);
    }


    /** --- FUNCTIONS --- */

    private function getData()
    {
        return array(
            [
                'quantity' => 1,
                'code' => 'TSX34634534',
                'tax' => 0.3,
                'orderPrice' => 14000,
                'totalPrice' => 17000,
                'totalDiscount' => null,
                'employeeId' => 1,
            ]
        );
    }

}
