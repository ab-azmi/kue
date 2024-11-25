<?php

namespace Database\Seeders\Employee;

use App\Models\Employee\EmployeeUser;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'address' => 'Jl Busung lapar 3',
                'phone' => '08123456789',
                'bankNumber' => '1234567890',
            ],
            [
                'address' => 'Jl Raja no 12',
                'phone' => '08123456789',
                'bankNumber' => '1234567890',
            ],
        ];
        $data = $this->getData();

        foreach ($data as $index => $item) {
            $u = EmployeeUser::create($item);
            $u->employee()->create($employees[$index])->salary()->create(['totalSalary' => 9800000]);
        }
    }

    /** --- FUNCTIONS --- */
    private function getData()
    {
        return [
            [
                'name' => 'John Doe',
                'email' => 'john@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@gmail.com',
                'password' => bcrypt('password'),
            ],
        ];
    }
}
