<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $fixedCategories = [
            ['title' => 'Электроника', 'slug' => 'electronics', 'is_active' => true],
            ['title' => 'Одежда', 'slug' => 'clothing', 'is_active' => true],
            ['title' => 'Книги', 'slug' => 'books', 'is_active' => true],
            ['title' => 'Дом и сад', 'slug' => 'home-garden', 'is_active' => true],
            ['title' => 'Спорт', 'slug' => 'sports', 'is_active' => true],
            ['title' => 'Красота', 'slug' => 'beauty', 'is_active' => true],
            ['title' => 'Автомобили', 'slug' => 'automotive', 'is_active' => false],
            ['title' => 'Игрушки', 'slug' => 'toys', 'is_active' => true],
        ];

        foreach ($fixedCategories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        Category::factory(7)->create();

        $this->command->info('✅ Создано ' . Category::count() . ' категорий');
    }
}
