<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_master_countries';

    protected $fillable = [
        'sortname',
        'country_name',
        'phonecode',
        'status',
        'created_at',
        'created_at'
     ];
}