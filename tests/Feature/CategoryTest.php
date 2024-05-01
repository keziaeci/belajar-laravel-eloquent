<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
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
                'name' => "Name $i"
            ];
        }

        // Category::insert() dan Category::query()->insert() cara kerjanya sama
        $result = Category::query()->insert($categories);
        
        // dd($result);
        assertTrue($result);
        
        // Category::count() dan Category::query()->count() cara kerjanya sama
        $total = Category::query()->count();
        // dd($categories);
        assertEquals(10, $total);
    }

    function testFind() {
        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");
        // dd($category);
        assertNotNull($category);
        assertEquals("FOOD", $category->id);
        assertEquals("Food", $category->name);
        assertEquals("Food Category", $category->description);
    }
    
    function testUpdate() {
        $this->seed(CategorySeeder::class);
    
        $category = Category::find("FOOD");
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

        $categories = Category::whereNull('description')->get();
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

        $categories = Category::whereNull('description')->get();
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

        Category::whereNull('description')->update([
            'description' => 'updated',
        ]);

        $total = Category::where('description', 'updated')->count();
        assertEquals(10,$total);
    }

    function testDelete() {
        $this->seed(CategorySeeder::class);

        $category = Category::find('FOOD');
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

        $category = Category::find("FOOD");
        $category->fill($req);
        $category->save();

        assertNotNull($category->id);
    }

    function testSoftDelete() {
        
    }
}
