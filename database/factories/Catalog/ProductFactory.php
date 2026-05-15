<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [

            'category_id' => Category::factory(),

            'name' => ucfirst($this->faker->words(3, true)),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'image_url' => $this->faker->imageUrl(640, 480, 'food'),
            'manage_stock' => $this->faker->boolean(70),
            'stock_quantity' => $this->faker->randomFloat(3, 0, 100),

            'is_active' => true,
        ];
    }

    /**
     * Estado para produtos inativos
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Estado para produtos sem controle de estoque
     */
    public function withoutStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'manage_stock' => false,
            'stock_quantity' => 0,
        ]);
    }
}
