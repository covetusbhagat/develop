<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_category';

    protected $fillable = [
        'category_name',
        'category_image',
        'created_at',
        'updated_at',
        'status'
        
     ];
}