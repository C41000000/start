<?php

declare(strict_types=1);

namespace Database\Seeders\Catalog;

use App\Models\Catalog\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cria as categorias reais principais do nosso PDV
        $categories = [
            ['name' => 'Bebidas', 'uuid' => Str::uuid(), 'description' => 'Refrigerantes, Sucos e Cervejas', 'sort_order' => 1, 'is_active' => true],
            ['name' => 'Lanches', 'uuid' => Str::uuid(), 'description' => 'Hambúrgueres artesanais e tradicionais', 'sort_order' => 2, 'is_active' => true],
            ['name' => 'Porções', 'uuid' => Str::uuid(), 'description' => 'Porções quentes e frias', 'sort_order' => 3, 'is_active' => true],
            ['name' => 'Sobremesas', 'uuid' => Str::uuid(), 'description' => 'Doces, tortas e sorvetes', 'sort_order' => 4, 'is_active' => true],
        ];

        foreach ($categories as $category) {

            Category::updateOrCreate(['name' => $category['name']], $category);
        }

        // Category::factory(10)->create();
    }
}
