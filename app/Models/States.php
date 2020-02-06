<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_master_states';

    protected $fillable = [
        'state_name',
        'country_id',
        'status',
        'created_at',
        'updated_at' 
     ];
}