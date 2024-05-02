<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ScopedBy([IsActiveScope::class])]
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','description','is_active']; 

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;


    function products() : HasMany {
        return $this->hasMany(Product::class);
    }
    
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::addGlobalScope(new IsActiveScope);
    // } bisa pakai ini atau yang diatas

    function cheapestProduct() : HasOne {
        return $this->hasOne(Product::class, 'category_id', 'id')->oldest('price');
    }

    function mostExpensiveProduct() : HasOne {
        return $this->hasOne(Product::class, 'category_id', 'id')->latest('price');
    }

    function reviews() : HasManyThrough {
        return $this->hasManyThrough(Review::class,Product::class,'category_id','product_id','id','id');
    }
}
