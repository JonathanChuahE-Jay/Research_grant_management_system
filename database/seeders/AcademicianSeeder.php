<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Academician; 
use App\Models\User;
use Faker\Factory as Faker;

class AcademicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $users = [
            [
                'name' => 'Dr. John Doe',
                'email' => 'john@gmail.com',
                'password' => bcrypt('uni10pass!'),
                'role' => 'project_member',
                'staff_number' => 'A001',
                'college' => 'Science',
                'department' => 'Computer Science',
                'position' => 'Professor',
            ],
            [
                'name' => 'Dr. Angel',
                'email' => 'angel@gmail.com',
                'password' => bcrypt('uni10pass!'),
                'role' => 'project_member',
                'staff_number' => 'A002',
                'college' => 'Engineering',
                'department' => 'Electrical Engineering',
                'position' => 'Assoc Prof',
            ],
            [
                'name' => 'Dr. James',
                'email' => 'james@gmail.com',
                'password' => bcrypt('uni10pass!'),
                'role' => 'project_member',
                'staff_number' => 'A003',
                'college' => 'Arts',
                'department' => 'History',
                'position' => 'Lecturer',
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'role' => $userData['role'], 
            ]);

            Academician::create([
                'user_id' => $user->id,
                'staff_number' => $userData['staff_number'],
                'college' => $userData['college'],
                'department' => $userData['department'],
                'position' => $userData['position'],
            ]);
        }
    }
}
