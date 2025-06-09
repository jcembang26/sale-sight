<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'date', 'time', 'created_at', 'updated_at'];
    
}
