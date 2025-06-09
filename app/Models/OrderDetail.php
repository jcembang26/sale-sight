<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $table = 'order_details';

    protected $primaryKey = 'id';
    protected $fillable = ['id', 'order_id', 'product_id', 'quantity', 'created_by', 'deleted_at', 'updated_by', 'created_at', 'updated_at'];
}
