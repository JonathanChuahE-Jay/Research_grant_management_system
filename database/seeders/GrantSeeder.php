<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grant;

class GrantSeeder extends Seeder
{
    public function run()
    {
        $grants = [
            [
                'title' => 'Hospital Research Grant',
                'provider' => 'John Doe',
                'amount' => 25000.00,
                'start_date' => '2024-01-01',
                'duration_months' => 12,
                'academician_id' => 3,
            ],
            [
                'title' => 'Cancer Research Funding',
                'provider' => 'Jane smith',
                'amount' => 45000.50,
                'start_date' => '2024-02-01',
                'duration_months' => 24,
                'academician_id' => 1,
            ],
            [
                'title' => 'AI and Robotics Grant',
                'provider' => 'Robert jones',
                'amount' => 35000.75,
                'start_date' => '2024-03-01',
                'duration_months' => 18,
                'academician_id' => 1,
            ],
        ];

        foreach ($grants as $grant) {
            Grant::create($grant);
        }
    }
}
