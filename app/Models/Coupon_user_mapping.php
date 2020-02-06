<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon_user_mapping extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_coupon_user_mapping';

    protected $fillable = [
        'coupon_id',
        'user_id',
        'used_count',
        'created_at',
        'updated_at',
        'status'
     ];
}