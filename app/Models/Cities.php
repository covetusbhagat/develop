<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_master_cities';

    protected $fillable = [
        'city_name',
        'state_id',
        'status',
        'created_at',
        'updated_at'
    ];
}