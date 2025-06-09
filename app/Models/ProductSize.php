<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = 'product_sizes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
}
