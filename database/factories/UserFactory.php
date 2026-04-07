<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'password' => Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'hr', 'inventory', 'employee']),
            'employee_id' => Employee::factory(),
            'remember_token' => fake()->randomAscii(),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function hr(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'hr',
        ]);
    }

    public function inventory(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'inventory',
        ]);
    }

    public function employeeRole(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'employee',
        ]);
    }
}
