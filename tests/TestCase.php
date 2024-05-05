<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function setUp(): void {
        parent::setUp();
        DB::delete("delete from images");
        DB::delete("delete from taggables");
        DB::delete("delete from tags");
        DB::delete("delete from categories");
        DB::delete("delete from vouchers");
        DB::delete("delete from comments");
        DB::delete("delete from wallets");
        DB::delete("delete from customers");
    }
}
