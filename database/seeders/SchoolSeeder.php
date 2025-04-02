<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $schools = [
            ['name' => 'Aissa Institut', 'adress' => '7-15 avenue de la porte de la vilette 75019 Paris', 'access' => true],
        ];

        School::insert($schools);
    }
}
