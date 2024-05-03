<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Customer extends Model
{
    use HasFactory;


    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    function wallet() : HasOne {
        return $this->hasOne(Wallet::class,'customer_id','id');
    }

    function virtualAccount() : HasOneThrough {
        return $this->hasOneThrough(VirtualAccount::class,Wallet::class,
        'customer_id', //relasi wallet ke customer melalui customer_id
        'wallet_id',//relasi virtual account ke wallet melalui wallet_id
        'id',   
        'id'
    );}

    function reviews() : HasMany {
        return $this->hasMany(Review::class, 'customer_id', 'id');
    }

    function likeProducts() : BelongsToMany {
        return $this->belongsToMany(Product::class,'customers_likes_products','customer_id', 'product_id')
        // ->withPivot('created_at');
        ->withTimestamps()
        ->using(Like::class);
    }
    
    function likeProductsLastWeek() : BelongsToMany {
        return $this->belongsToMany(Product::class,'customers_likes_products','customer_id', 'product_id')
        // ->withPivot('created_at');
        ->withTimestamps()
        ->wherePivot('created_at', '>=' , Carbon::now()->addDays(-7))
        ->using(Like::class);
    }
}
