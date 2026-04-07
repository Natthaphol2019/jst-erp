<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'category_id' => ItemCategory::factory(),
            'item_code' => fake()->unique()->numerify('ITEM#####'),
            'name' => fake()->words(3, true),
            'type' => fake()->randomElement(['disposable', 'returnable', 'equipment', 'consumable']),
            'unit' => fake()->randomElement(['piece', 'box', 'set', 'unit', 'kg', 'liter']),
            'current_stock' => fake()->numberBetween(0, 1000),
            'min_stock' => fake()->numberBetween(10, 100),
            'location' => fake()->randomElement(['Warehouse A', 'Warehouse B', 'Storage Room 1', 'Office Cabinet']),
            'status' => fake()->randomElement(['available', 'unavailable', 'maintenance']),
        ];
    }

    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }

    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'unavailable',
        ]);
    }

    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'current_stock' => fake()->numberBetween(0, 10),
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'current_stock' => 0,
        ]);
    }
}
