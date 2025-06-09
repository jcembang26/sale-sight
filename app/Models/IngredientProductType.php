<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientProductType extends Model
{
    protected $table = 'ingredient_product_type';
    protected $fillable = [
        'ingredient_id',
        'product_type_id',
        'created_at',
        'created_by'
    ];
}
