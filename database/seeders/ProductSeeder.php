<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Product();
        $category->id = '1';
        $category->name = 'Product 1';
        $category->description = 'Desc 1';
        $category->category_id = "FOOD";
        $category->save();
    }
}
