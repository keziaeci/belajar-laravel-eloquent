<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class VoucherTest extends TestCase
{
    function testCreateVoucher() {
        $voucher = new Voucher();
        $voucher->name = 'Sample Voucher';
        $voucher->voucher_code = '121212121';
        $voucher->save();

        // dd($voucher);
        assertNotNull($voucher->id);
    }

    function testCreateVoucherUUID() {
        $voucher = new Voucher();
        $voucher->name = 'Sample Voucher';
        $voucher->save();

        // dd($voucher);
        assertNotNull($voucher->id);
        assertNotNull($voucher->voucher_code);
    }
    
    function testSoftDelete() {
        $this->seed(VoucherSeeder::class);
        $voucher = Voucher::where('name', 'Voucher Sample')->first();
        $voucher->delete();
        
        $voucher = Voucher::where('name', 'Voucher Sample')->first();
        assertNull($voucher);
        
        // untuk mengambil data yang sudah di softdelete
        $voucher = Voucher::withTrashed()->where('name', 'Voucher Sample')->first();
        assertNotNull($voucher);
    }

    
}
