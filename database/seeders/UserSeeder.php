<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
            ]
        ];
        $data = $this->getData();
        //insert data
        foreach ($data as $index => $item) {
            $u = User::create($item);
            $u->employee()->create($employees[$index]);
            $u->salary()->create([
            'totalSalary' => "980000",
            ]);
        }
    }


    /** --- FUNCTIONS --- */

    private function getData()
    {
        return array(
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
        );
    }
}
