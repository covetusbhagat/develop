<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class ProductReviews extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_product_reviews';

    protected $fillable = [
        'user_id',
        'product_id',
        'reviews',
        'created_at',
        'updated_at',
        'status'
     ];
}