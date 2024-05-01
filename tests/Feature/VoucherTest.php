<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

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
    
}
