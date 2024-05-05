<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voucher extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

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

    function comments() : MorphMany {
        return $this->morphMany(Comment::class, 'commentable');
    }
    
    function scopeActive($query) {
        $query->where('is_active', true);
    }

    function scopeNonActive($query) {
        $query->where('is_active', false);
    }
}
