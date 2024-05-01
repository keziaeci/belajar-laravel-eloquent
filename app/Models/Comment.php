<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // protected $table = 'comments';
    // protected $primaryKey = 'id';
    // protected $keyType = 'int';
    // public $incrementing = true;
    // public $timestamps = true;


    // attribut default
    protected $attributes = [
        'title' => 'Sample Title',
        'comment' => 'Sample Comment',
    ];
}
