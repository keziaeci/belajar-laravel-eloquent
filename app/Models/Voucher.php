<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'vouchers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    function uniqueIds()
    {
        // ketika ingin menambah kolom lain agar menggunakan uuid
        return [$this->primaryKey, 'voucher_code'];   
    }
}
