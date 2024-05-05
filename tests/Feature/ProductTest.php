<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\VoucherSeeder;
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
    
    function testHasOneOfMany() {
        $this->seed([CategorySeeder::class,ProductSeeder::class]);
        $category = Category::find('FOOD');
        assertNotNull($category);
        assertNotNull($category->products);
        // dd($category->cheapestProduct);
        assertEquals("1",$category->cheapestProduct->id);
        assertEquals("2",$category->mostExpensiveProduct->id);
    }

    function testOneToManyPolymorphic() {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class , CommentSeeder::class]);
        
        $prod = Product::find('1');
        assertNotNull($prod);
        assertNotNull($prod->comments);
        
        $prod->comments->each(function ($comment) use ($prod) {
            assertEquals(Product::class,$comment->commentable_type);
            assertEquals($prod->id,$comment->commentable_id);
        });
        // dd($prod->comments);
    }
    
    function testOneOfManyPolymorphic() {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class , CommentSeeder::class]);
        $prod = Product::find('1');
        assertNotNull($prod);
        assertNotNull($prod->latestComment);
        assertNotNull($prod->oldestComment);
        // dd($prod->latestComment);
        // dd($prod->oldestComment);
    }

    
}   
