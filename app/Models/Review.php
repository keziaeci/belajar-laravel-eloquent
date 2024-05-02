<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    function customer() : BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    function product() : BelongsTo {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
