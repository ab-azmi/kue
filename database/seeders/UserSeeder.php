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
        $data = $this->getData();
        //insert data
        foreach ($data as $item) {
            $u = User::create($item);
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
