<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_subcategory';

    protected $fillable = [
        'category_id',
        'subcategory_name',
        'subcategory_image',
        'created_at',
        'updated_at',
        'status'
     ];
}