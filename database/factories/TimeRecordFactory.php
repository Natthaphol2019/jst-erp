<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\TimeRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeRecordFactory extends Factory
{
    protected $model = TimeRecord::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'work_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'status' => fake()->randomElement(['present', 'absent', 'late', 'leave']), // Only valid enum values
            'check_in_time' => fake()->time('H:i'),
            'check_out_time' => fake()->time('H:i'),
            'source' => fake()->randomElement(['manual', 'biometric', 'web']),
            'is_locked' => false,
            'remark' => fake()->sentence(),
        ];
    }

    public function present(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'present',
        ]);
    }

    public function absent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'absent',
        ]);
    }

    public function late(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'late',
        ]);
    }

    public function locked(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_locked' => true,
        ]);
    }
}
