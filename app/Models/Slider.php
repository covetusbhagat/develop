<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_slider';

    protected $fillable = [
        'slider_image',
        'created_at',
        'updated_at',
        'status'
     ];
}