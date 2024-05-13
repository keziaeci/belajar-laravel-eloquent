<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use SebastianBergmann\CodeUnit\FunctionUnit;
use Tests\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class CategoryTest extends TestCase
{
    function testInsert() {
        $cat = new Category();

        $cat->id = 'GADGET';
        $cat->name = 'Gadget';
        $cat->description = 'Gadgetin';
        $result = $cat->save();
        
        assertTrue($result);
    }

    function testInsertMany() {
        $categories = [];
        for ($i=0; $i < 10; $i++) { 
            $categories[] = [
                'id' => "ID $i",
                'name' => "Name $i",
                'is_active' => true
            ];
        }

        
        // Category::insert() dan Category::query()->insert() cara kerjanya sama
        $result = Category::query()->insert($categories);
        
        // dd($result);
        assertTrue($result);
        
        // Category::count() dan Category::query()->count() cara kerjanya sama
        $total = Category::query()->count();
        // dd($total);
        // dd($categories);
        assertEquals(10, $total);
    }

    function testFind() {
        $this->seed(CategorySeeder::class);

        $category = Category::withoutGlobalScope(IsActiveScope::class)->find("FOOD");
        // dd($category);
        assertNotNull($category);
        assertEquals("FOOD", $category->id);
        assertEquals("Food", $category->name);
        assertEquals("Food Category", $category->description);
    }
    
    function testUpdate() {
        $this->seed(CategorySeeder::class);
    
        $category = Category::withoutGlobalScope(IsActiveScope::class)->find("FOOD");
        $category->name = 'Food Update';

        $res = $category->update();
        // $res = $category->save(); sama saja dengan update()

        assertTrue($res);
    }

    function testSelect() {
        for ($i=0; $i < 5 ; $i++) { 
            $category = new Category();
            $category->id = "ID $i";
            $category->name = "name $i";
            $category->save();
        }

        $categories = Category::withoutGlobalScope(IsActiveScope::class)->whereNull('description')->get();
        // dd($categories->count());
        assertCount(5,$categories);
        $categories->each(function ($cat) {
            assertNull($cat->description);
        });
    }

    function testUpdateSelectResult() {
        for ($i=0; $i < 5 ; $i++) { 
            $category = new Category();
            $category->id = "ID $i";
            $category->name = "name $i";
            $category->save();
        }

        $categories = Category::withoutGlobalScope(IsActiveScope::class)->whereNull('description')->get();
        // dd($categories->count());
        assertCount(5,$categories);
        $categories->each(function ($cat) {
            assertNull($cat->description);
            // karena hasil dari query itu berupa objek modelnya, maka kita bisa langsung melakukan operasi
            $cat->description = 'updated';
            $cat->update();
        });
    }

    function testUpdateMany() {
        $categories = [];
        for ($i=0; $i < 10; $i++) { 
            $categories[] = [
                'id' => "ID $i",
                'name' => "Name $i"
            ];
        }
        $result = Category::query()->insert($categories);
        assertTrue($result);

        Category::withoutGlobalScope(IsActiveScope::class)->whereNull('description')->update([
            'description' => 'updated',
        ]);

        
        $total = Category::withoutGlobalScope(IsActiveScope::class)->where('description', 'updated')->count();
        // dd($total);
        assertEquals(10,$total);
    }

    function testDelete() {
        $this->seed(CategorySeeder::class);

        $category = Category::withoutGlobalScope(IsActiveScope::class)->find('FOOD');
        $result = $category->delete();

        assertTrue($result);

        $total = Category::count();

        assertEquals(0,$total);
    }

    function testDeleteMany() {
        $categories = [];
        for ($i=0; $i < 10; $i++) { 
            $categories[] = [
                'id' => "ID $i",
                'name' => "Name $i"
            ];
        }
        $result = Category::query()->insert($categories);
        assertTrue($result);

        Category::whereNull('description')->delete();

        $total = Category::count();
        assertEquals(0,$total);
    }

    function testCreate() {
        $req = [
            'id' => 'FOOD',
            'name' => 'Food',
            'description' => 'Food',
        ];

        $category = new Category($req);
        $category->save();

        assertNotNull($category->id);
    }

    function testCreateMethod() {
        $req = [
            'id' => 'FOOD',
            'name' => 'Food',
            'description' => 'Food',
        ];

        $category = Category::create($req);
        assertNotNull($category);
    }

    function testUpdateUsingFill() {
        $this->seed(CategorySeeder::class);

        $req = [
            'name' => 'Food Updated',
            'description' => 'Food Updated',
        ];

        $category = Category::withoutGlobalScope(IsActiveScope::class)->find("FOOD");
        $category->fill($req);
        $category->save();

        assertNotNull($category->id);
    }

    function testFalseGlobalScope() {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = false;
        $category->save();

        // data akan null karena global scope hanya ambil data yang is_active = true
        $res = Category::find('FOOD');
        assertNull($res);

        // jika ingin banyak scope maka gunakan withoutGlobalScopes
        $res = Category::withoutGlobalScope(IsActiveScope::class)->find('FOOD');
        assertNotNull($res);
    }

    function testQueryCategory()  {
        $this->seed([CategorySeeder::class,ProductSeeder::class]);

        $category = Category::find('FOOD');
        assertNotNull($category);
        assertNotNull($category->products);
        assertCount(2,$category->products);
    }

    function testOneToManyInsert() {
        $category = new Category();
        $category->id = '1';
        $category->name = 'Category 1';
        $category->description = 'Desc 1';
        $category->is_active =  true;
        $category->save();
        
        assertNotNull($category);
        
        // dd($category->wallet);
        $product = new Product();
        $product->id = '1';
        $product->name = 'Product 1';
        $product->description = 'Desc 1';
        $category->products()->save($product);

        assertNotNull($category->products);
        assertNotNull($product->category->id);
    }

    function testRelationshipQuery() {
        $this->seed([CategorySeeder::class,ProductSeeder::class]);
        
        $category = Category::find('FOOD');
        $product = $category->products;
        assertCount(2,$product);
        
        $outOfStockProducts = $category->products()->where('stock' , '<=' , 0)->get();
        assertCount(2,$outOfStockProducts);
    }

    function testHasManyThrough() {
        $this->seed([CategorySeeder::class,ProductSeeder::class,CustomerSeeder::class,ReviewSeeder
        ::class]);
        
        $category = Category::find('FOOD');
        assertNotNull($category);
        
        assertNotNull($category->reviews);
        assertCount(2,$category->reviews);
    }
    
    
    function testQueryingRelation() {
        $this->seed([CategorySeeder::class,ProductSeeder::class]);

        $category = Category::find('FOOD');
        $products = $category->products()->where('price','>', 0)->get();

        assertCount(1,$products);
        assertEquals("2",$products[0]->id);
        // dd($products[0]->id);
    }

    
}
