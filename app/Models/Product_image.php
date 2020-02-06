<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_product_image';

    protected $fillable = [
        'product_id',
        'product_image',
        'created_at',
        'updated_at',
        'status'
     ];
}