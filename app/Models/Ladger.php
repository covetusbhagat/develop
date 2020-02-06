<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ladger extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_ladger';

    protected $fillable = [
        'description',
        'credit_amount',
        'debit_amount',
        'created_at',
        'updated_at',
        'status'
     ];
}