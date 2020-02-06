<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral_allot_user extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_referral_allot_user';

    protected $fillable = [
        'referral_code',
        'user_id',
        'referral_percentage',
        'maximum_limit',
        'created_at',
        'updated_at',
        'expired_at',
        'status'
     ];
}