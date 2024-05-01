<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class ProductTest extends TestCase
{
    function testQueryProduct() {
        $this->seed([CategorySeeder::class,ProductSeeder::class]);

        $product = Product::find('1');
        assertNotNull($product);
        assertNotNull($product->category);
        // dd($product->category);
        assertEquals("FOOD",$product->category->id);
    }
}
