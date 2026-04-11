<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple',   'slug' => 'apple',   'is_active' => true],
            ['name' => 'Samsung', 'slug' => 'samsung', 'is_active' => true],
            ['name' => 'Sony',    'slug' => 'sony',    'is_active' => true],
            ['name' => 'Nike',    'slug' => 'nike',    'is_active' => true],
            ['name' => 'Adidas',  'slug' => 'adidas',  'is_active' => true],
            ['name' => 'Generic', 'slug' => 'generic', 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(['slug' => $brand['slug']], $brand);
        }

        $shopCategories = [
            'Electronics',
            'Clothing',
            'Footwear',
            'Accessories',
            'Home & Garden',
            'Sports',
            'Toys',
            'Beauty',
        ];

        foreach ($shopCategories as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'slug' => Str::slug($name), 'type' => 'shop', 'is_active' => true]
            );
        }

        $blogCategories = [
            'News',
            'Tutorials',
            'Reviews',
            'Tips & Tricks',
        ];

        foreach ($blogCategories as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'slug' => Str::slug($name), 'type' => 'blog', 'is_active' => true]
            );
        }
    }
}
