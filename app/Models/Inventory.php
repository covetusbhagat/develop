<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_inventory';

    protected $fillable = [
        'shopkeeper_id',
        'product_id',
        'total_quantity',
        'lost_quantity',
        'damage_quantity',
        'on_rent_quantity',
        'available_quantity',
        'created_at',
        'updated_at',
        'status'
     ];
}