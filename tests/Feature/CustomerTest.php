<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
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
        $this->testInsertManyToMany();

        $customer = Customer::find('RENA');
        $p = Product::find('1');
        // dd($customer->likeProducts);
        // assertNotNull($p);
        assertNotNull($customer->likeProducts);

        $customer->likeProducts()->detach('1');
        // $prod = $customer->likeProducts;
        // dd($prod);
        dd($p->likedBy);
        // dd($p);
        // assertCount(0, $prod);
        // dd($customer->likeProducts()->detach('1'));
        // dd($customer->likeProducts);
        assertCount(0,$customer->likeProducts);
    }
}
