<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\UserSeeder;  
use Database\Seeders\GrantSeeder; 
use Database\Seeders\AcademicianSeeder; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class, 
            AcademicianSeeder::class
        ]);
    }
}
