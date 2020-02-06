<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_notification';

    protected $fillable = [
        'by_id',
        'to_id',
        'massage',
        'displaylink',
        'created_at',
        'updated_at',
        'status'
        
     ];
}