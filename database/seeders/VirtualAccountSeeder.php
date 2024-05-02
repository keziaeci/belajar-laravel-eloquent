<?php

namespace Database\Seeders;

use App\Models\VirtualAccount;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = Wallet::where('customer_id', 'RENA')->firstOrFail();

        $vA = new VirtualAccount();
        $vA->bank = 'BCA';
        $vA->va_number = '123132123';
        $vA->wallet_id = $wallet->id;
        $vA->save();
    }
}
