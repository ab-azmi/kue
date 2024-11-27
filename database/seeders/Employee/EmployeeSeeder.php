<?php

namespace Database\Seeders\Employee;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeUser;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'email' => 'john@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'email' => 'jane@gmail.com',
                'password' => bcrypt('password'),
            ],
        ];

        $data = $this->getData();

        foreach ($data as $index => $employee) {
            $emp = Employee::create($employee);
            $emp->user()->create($user[$index]);
            $emp->salary()->create(['totalSalary' => 1000000]);
        }
    }

    /** --- FUNCTIONS --- */
    private function getData()
    {
        return [
            [
                'name' => 'John Doe',
                'address' => 'Jl Busung lapar 3',
                'phone' => '08123456789',
                'bankNumber' => '1234567890',
            ],
            [
                'name' => 'Jane Doe',
                'address' => 'Jl Raja no 12',
                'phone' => '08123456789',
                'bankNumber' => '1234567890',
            ],
        ];
    }
}
