<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_coupon';

    protected $fillable = [
        'coupon_code',
        'start_date',
        'end_date',
        'coupon_percentage',
        'coupon_uses_time',
        'maximum_limit',
        'created_at',
        'updated_at',
        'status'
     ];
}