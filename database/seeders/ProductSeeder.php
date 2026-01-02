<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Проверяем, есть ли категории
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        // Создаем фиксированные популярные товары
        $featuredProducts = [
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Новейший смартфон Apple с камерой 48 МП',
                'price' => 1299.99,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => Category::where('slug', 'electronics')->first()->id,
            ],
            [
                'name' => 'Футболка Premium Cotton',
                'description' => 'Мужская футболка из 100% хлопка',
                'price' => 29.99,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => Category::where('slug', 'clothing')->first()->id,
            ],
            [
                'name' => 'Книга "Искусство программирования"',
                'description' => 'Полное руководство по алгоритмам',
                'price' => 89.50,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => Category::where('slug', 'books')->first()->id,
            ],
        ];

        foreach ($featuredProducts as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                $product
            );
        }

        Product::factory(50)->create();

        Product::factory(10)->active()->create();
        Product::factory(5)->featured()->create();

        $this->command->info('✅ Создано ' . Product::count() . ' товаров');
        $this->command->info('📊 Статистика:');
        $this->command->info('   - Активных: ' . Product::where('is_active', true)->count());
        $this->command->info('   - Рекомендуемых: ' . Product::where('is_featured', true)->count());
        $this->command->info('   - Средняя цена: $' . number_format(Product::avg('price'), 2));
    }
}
