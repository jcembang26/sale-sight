<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use SoftDeletes;

    protected $table = 'product_types';
    protected $primaryKey = 'product_type_id';
    public $incrementing = false; // because it's a string, not auto-increment
    protected $keyType = 'string'; // because it's a string, not integer

    protected $fillable = ['product_type_id', 'name', 'category_id', 'deleted_at', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $appends = ['category_name'];

    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : null;
    }
    
    public function category(): HasOne
    {
        return $this->hasOne(ProductCategory::class, 'id', 'category_id')->select(['id', 'name']);
    }
    
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_product_type', 'product_type_id', 'ingredient_id');
    }
}
