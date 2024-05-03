<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Wallet;
use Carbon\Carbon;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class CustomerTest extends TestCase
{
    function testOneToOne() {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]); //bisa dijadikan array
        // $this->seed(WalletSeeder::class);

        $customer = Customer::find('RENA');
        assertNotNull($customer);
        
        assertNotNull($customer->wallet);
        assertEquals(100000,$customer->wallet->amount);
        // dd($customer->wallet());
        // dd($customer->wallet);
    }

    function testOneToOneInsert() {
        $customer = new Customer();
        $customer->id = 'RENA';
        $customer->name = 'Rena';
        $customer->email = 'rena@gmail.com';
        $customer->save();

        // dd($customer->wallet);
        $wallet = new Wallet();
        $wallet->id = 1;
        $wallet->amount = 100000;
        $customer->wallet()->save($wallet);

        assertNotNull($customer->wallet);
        assertNotNull($wallet->customer->id);
    }

    function testHasOneThrough() {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]); 
        
        $customer = Customer::find('rena');
        assertNotNull($customer);

        assertNotNull($customer->virtualAccount);
        assertEquals('BCA',$customer->virtualAccount->bank);

        // dd($customer->virtualAccount);
    }

    function testInsertManyToMany() {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]); 
        
        $customer = Customer::find('RENA');
        assertNotNull($customer);

        /**
         * jadi kita nggak perlu bikin table jadi sebuahh model, tinggal kita panggil method nya saja
         * trus kita masukan ke tabel melalui attach.
         * contoh disini kita membuat customer RENA melakukan like ke product dengan id 1
         */
        $customer->likeProducts()->attach('1');
        $products = $customer->likeProducts;
        // dd($products[0]->id);
        assertNotNull($products);
        assertCount(1,$products);
        // assertEquals()
    }

    function testManyToManyDetach() {
        // $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]); 
        
        $this->testInsertManyToMany();
        
        $customer = Customer::find('RENA');
        // $customer->likeProducts()->attach('1');
        // $p = Product::find('1');
        // dd($customer->likeProducts);
        // assertNotNull($p);
        // assertNotNull($customer->likeProducts);
        // $customer->likeProducts->each(function ($item){
        //     // dd($item->name);
        //     // dd($item->pivot->customer_id);
        //     // dd($item->pivot->created_at);
        // });
        // dd($customer->likeProducts);

        $customer->likeProducts()->detach('1');
        // $prod = $customer->likeProducts;
        // dd($prod);
        // dd($p->likedBy);
        // dd($p->likedBy);
        // assertCount(0, $prod);
        // dd($customer->likeProducts()->detach('1'));
        assertCount(0,$customer->likeProducts);
    }

    function testPivotAttribute()  {
        $this->testInsertManyToMany();
        $customer = Customer::find('RENA');
        $customer->likeProducts->each(function ($item){
            assertEquals('RENA',$item->pivot->customer_id);
            assertEquals('1',$item->pivot->product_id);
            // dd($item->name);
            // dd($item->pivot->customer_id);
            // dd($item->pivot->customer);
            // dd($item->pivot->created_at);
            // dd(Carbon::now() >= Carbon::now()->addDays(-7));
            // dd($item->pivot->created_at->isLastWeek());
        });
    }

    function testPivotWithCondition() {
        $this->testInsertManyToMany();
        $customer = Customer::find('RENA');
        $customer->likeProductsLastWeek->each(function ($item){
            assertNotNull($item);
            assertNotNull($item->pivot);
            assertEquals('RENA',$item->pivot->customer_id);
            assertEquals('1',$item->pivot->product_id);
        });
    }
    
    function testPivotModel() {
        $this->testInsertManyToMany();
        $customer = Customer::find('RENA');
        $customer->likeProductsLastWeek->each(function ($item){
            assertNotNull($item);
            assertNotNull($item->pivot->customer);
            assertNotNull($item->pivot->product);
            assertEquals('RENA',$item->pivot->customer_id);
            assertEquals('1',$item->pivot->product_id);
        });
    }

    function testOneToOnePolymorphic()  {
        $this->seed([CustomerSeeder::class, CategorySeeder::class,ProductSeeder::class, ImageSeeder::class]);
        
        $customer = Customer::find('RENA');
        assertNotNull($customer);
        assertNotNull($customer->image);
        assertEquals('https://pin.it/2uGiO7hR6',$customer->image->url);
        
    }
}
