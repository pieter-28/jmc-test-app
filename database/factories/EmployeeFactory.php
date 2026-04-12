<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Department;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $dateOfBirth = $this->faker->dateTimeBetween('-60 years', '-20 years');
        $maritalStatus = $this->faker->randomElement(['kawin', 'tidak kawin']);

        $position = Position::inRandomOrder()->first() ?? Position::firstOrFail();
        $department = Department::inRandomOrder()->first() ?? Department::firstOrFail();
        $province = Province::inRandomOrder()->first() ?? Province::firstOrFail();
        $district = District::where('province_id', $province->id)->inRandomOrder()->first() ?? District::where('province_id', $province->id)->firstOrFail();
        $subDistrict = SubDistrict::where('district_id', $district->id)->inRandomOrder()->first() ?? SubDistrict::where('district_id', $district->id)->firstOrFail();

        return [
            'nip' => 'NIP' . $this->faker->unique()->numerify('##############'),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'place_of_birth' => $this->faker->city(),
            'date_of_birth' => $dateOfBirth,
            'province_id' => $province->id,
            'district_id' => $district->id,
            'sub_district_id' => $subDistrict->id,
            'address' => $this->faker->address(),
            'marital_status' => $maritalStatus,
            'number_of_children' => $this->faker->randomElement([0, 1, 2, 3, 4]),
            'position_id' => $position->id,
            'department_id' => $department->id,
            'start_date' => $this->faker->dateTimeBetween('-10 years', 'now'),
            'employment_type' => $this->faker->randomElement(['tetap', 'kontrak', 'magang']),
            'age' => $this->faker->numberBetween(20, 65),
            'is_active' => true,
        ];
    }
}
