<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_cart';

    protected $fillable = [
        'user_id',
        'product_id',
        'inventory_id',
        'start_date_time',
        'end_date_time',
        'rate_per_item',
        'total_quantity',
        'total_amount',
        'direct_buy_status',
        'created_at',
        'updated_at',
        'status'
        
     ];
}