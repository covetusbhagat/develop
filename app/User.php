<?php

namespace App;


use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verify_status',
        'mobile',
        'mobile_verify_status',
        'profile_image',
        'doc_image',
        'doc_aprove_status',
        'doc_aprove_by_id',
        'email_verified_at',
        'mobile_verified_at',
        'password',
        'role_id',
        'remember_token',
        'email_token', 
        'mobile_token',
        'my_referral_code',
        'friend_referral_code',
        'updated_at', 
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
