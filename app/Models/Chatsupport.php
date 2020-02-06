<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chatsupport extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_chat_support';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'file_name',
        'file_location',
        'file_type',
        'status'
        
     ];
}