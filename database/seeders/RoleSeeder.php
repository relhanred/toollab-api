<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Director', 'slug' => 'director'],
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Registar', 'slug' => 'registar'],
            ['name' => 'Responsible', 'slug' => 'responsible'],
            ['name' => 'Student', 'slug' => 'student'],
            ['name' => 'Teacher', 'slug' => 'teacher'],
        ];

        Role::insert($roles);
    }
}
