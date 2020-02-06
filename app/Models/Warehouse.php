<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_warehouse';

    protected $fillable = [
        'warehouse_name',
        'created_at',
        'updated_at',
        'status' 
     ];
}