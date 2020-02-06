<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_roles';

    protected $fillable = [
        'role_name',
        'created_at',
        'updated_at',
        'status'
     ];
}