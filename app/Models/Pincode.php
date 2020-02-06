<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_pincode';

    protected $fillable = [
        'pincode',
        'created_at',
        'updated_at',
        'status'
     ];
}