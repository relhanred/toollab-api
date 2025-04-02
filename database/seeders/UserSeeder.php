<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['first_name' => 'Rayane', 'last_name' => 'QOUCHICH', 'email' => 'rayane.qouchich@gmail.com', 'password' => bcrypt('password'), 'access' => true],
//                ['first_name' => 'Sebastien', 'last_name' => 'AUVRAY', 'email' => 'rayane.qouchich@gmail.com', 'password' => bcrypt('password'), 'access' => true],
//                ['first_name' => 'Younes', 'last_name' => 'SERRA', 'email' => 'rayane.qouchich@gmail.com', 'password' => bcrypt('password'), 'access' => true],
//                ['first_name' => 'Redha', 'last_name' => 'EL HANTI', 'email' => 'rayane.qouchich@gmail.com', 'password' => bcrypt('password'), 'access' => true],
        ];
        
        User::insert($users);
    }
}
