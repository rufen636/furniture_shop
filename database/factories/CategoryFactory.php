<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->unique()->words($this->faker->numberBetween(1, 3), true);

        return [
            'title' => ucfirst($title),
            'slug' => \Str::slug($title),
            'description' => $this->faker->boolean(70) ? $this->faker->sentence(10) : null,
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
