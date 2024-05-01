<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

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
        $wallet->amount = 100000;
        $customer->wallet()->save($wallet);

        assertNotNull($customer->wallet);
        assertNotNull($wallet->customer->id);
    }
}
