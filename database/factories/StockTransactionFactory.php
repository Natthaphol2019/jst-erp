<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockTransactionFactory extends Factory
{
    protected $model = StockTransaction::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 100);
        
        return [
            'item_id' => Item::factory(),
            'transaction_type' => fake()->randomElement(['in', 'out', 'adjust']),
            'quantity' => $quantity,
            'balance' => fake()->numberBetween(0, 1000),
            'created_by' => User::factory(),
            'remark' => fake()->sentence(),
        ];
    }

    public function stockIn(): static
    {
        return $this->state(fn (array $attributes) => [
            'transaction_type' => 'in',
        ]);
    }

    public function stockOut(): static
    {
        return $this->state(fn (array $attributes) => [
            'transaction_type' => 'out',
        ]);
    }

    public function adjustment(): static
    {
        return $this->state(fn (array $attributes) => [
            'transaction_type' => 'adjust',
        ]);
    }
}
