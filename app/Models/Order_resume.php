<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_resume extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_order_resume';

    protected $fillable = [
        'order_id',
        'user_id',
        'apply_rate',
        'return_datetime',
        'amount',
        'created_at',
        'updated_at',
        'status'	
     ];
}