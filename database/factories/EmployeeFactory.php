<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $department = Department::factory();
        $position = Position::factory(['department_id' => $department]);
        
        return [
            'department_id' => $department,
            'position_id' => $position,
            'employee_code' => fake()->unique()->numerify('EMP#####'),
            'prefix' => fake()->randomElement(['Mr.', 'Mrs.', 'Ms.']),
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'start_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'status' => fake()->randomElement(['active', 'inactive']), // Only valid enum values
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
