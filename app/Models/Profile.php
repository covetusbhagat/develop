<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_profile';

    protected $fillable = [
        'extra_field',
        'created_at',
        'updated_at',
        'status'
     ];
}