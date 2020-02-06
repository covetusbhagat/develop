<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_transaction';

    protected $fillable = [
        'order_id',
        'transaction_type',
        'transaction_id',
        'transaction_amount',
        'created_at',
        'updated_at'
     ];
}