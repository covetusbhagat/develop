<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_complaint';

    protected $fillable = [
        'complaint_by',
        'subject',
        'complaint_text',
        'created_at',
        'updated_at',
        'status'
        
     ];
}