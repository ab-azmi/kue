<?php

namespace Database\Factories\Transaction;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeUser;
use App\Services\Number\Generator\TransactionNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber(1),
            'number' => TransactionNumber::generate(),
            'statusId' => $this->faker->randomElement([1, 2]),
            'tax' => $this->faker->randomFloat(0, 1000, 10000),
            'orderPrice' => $this->faker->randomFloat(0, 10000, 100000),
            'totalPrice' => $this->faker->randomFloat(0, 10000, 100000),
            'totalDiscount' => $this->faker->randomFloat(0, 1000, 10000),
            'employeeId' => Employee::all()->random()->id,
        ];
    }
}
