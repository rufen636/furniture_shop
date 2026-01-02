<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $categoryIds = Category::pluck('id')->toArray();

        return [
            'name' => $this->faker->words($this->faker->numberBetween(2, 5), true),
            'description' => $this->faker->boolean(80) ? $this->faker->paragraphs($this->faker->numberBetween(1, 3), true) : null,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'is_active' => $this->faker->boolean(85),
            'is_featured' => $this->faker->boolean(30),
            'category_id' => $this->faker->randomElement($categoryIds),
        ];
    }

    // Дополнительные состояния
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'is_active' => true,
        ]);
    }

}
