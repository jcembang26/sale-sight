<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'product_type_id';
    public $incrementing = false; // because it's a string, not auto-increment
    protected $keyType = 'string'; // because it's a string, not integer

    protected $fillable = ['product_type_id', 'name', 'category_id', 'deleted_at', 'created_at', 'created_by', 'updated_at', 'updated_by'];
}
