<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_product';

    protected $fillable = [
        'created_by_user_id',
        'category_id',
        'subcategory_id',
        'product_name',
        'brand',
        'purchase_cost',
        'mrp',
        'purchase_date',
        'rate',
        'rating',
        'description',
        'size',
        'color',
        'material',
        'featured_status',
        'created_at',
        'updated_at',
        'status'
     ];
}