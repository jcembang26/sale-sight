<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['product_id', 'product_type_id', 'size_id', 'price', 'deleted_at', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $appends = ['size_name'];

    public function getSizeNameAttribute()
    {
        return $this->size ? $this->size->name : null;
    }
    
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'product_id');
    }
    
    public function size(): HasOne
    {
        return $this->hasOne(ProductSize::class, 'id', 'size_id')->select('id', 'name');
    }
    
    public function productType(): HasOne
    {
        return $this->hasOne(ProductType::class, 'product_type_id', 'product_type_id');
    }
}
