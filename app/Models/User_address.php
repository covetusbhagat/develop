<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_address extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_user_address';

    protected $fillable = [
        'users_id',
        'house_no',
        'land_mark',
        'state_id',
        'city_id',
        'pincode',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
        'status'
     ];
}