<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model 
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_wishlist';

    protected $fillable = [
        'user_id',
        'product_id',
        'created_at',
        'updated_at',
        'status'
     ];
}