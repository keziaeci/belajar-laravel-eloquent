<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
