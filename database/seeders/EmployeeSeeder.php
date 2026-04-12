<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 25 dummy employees
        Employee::factory()->count(25)->create();
    }
}
