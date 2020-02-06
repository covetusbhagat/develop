<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_order';

    protected $fillable = [
        'user_id',
        'user_address',
        'product_id',
        'inventory_id',
        'shopkeeper_id',
        'estimate_start_datetime',
        'estimate_end_datetime',
        'apply_rate',
        'quantity',
        'total_amount',
        'delivery_type',
        'delivery_otp',
        'delivery_otp_verify',
        'return_type',
        'return_otp',
        'return_otp_verify',
        'delivery_datetime',
        'return_datetime',
        'extend_rate',
        'first_amount',
        'final_amount',
        'created_at',
        'updated_at',
        'status'

     ];
}