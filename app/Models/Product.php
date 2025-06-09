<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'product_id';
    public $incrementing = false; // because it's a string, not auto-increment
    protected $keyType = 'string'; // because it's a string, not integer

    protected $fillable = ['product_id', 'product_type_id', 'size_id', 'price', 'deleted_at', 'created_at', 'created_by', 'updated_at', 'updated_by'];
}
