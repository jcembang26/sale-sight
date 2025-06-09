<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $fillable = ['id', 'name', 'category_id', 'deleted_at', 'created_at', 'updated_at'];
}
