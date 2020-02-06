<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{

    protected  $primaryKey = 'id';
    protected $table = 'tbl_referral';

    protected $fillable = [
        'referral_code',
        'referral_percentage',
        'use_days',
        'maximum_limit',
        'created_at',
        'updated_at',
        'status'
    ];
}