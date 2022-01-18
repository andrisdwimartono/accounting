<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Model;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $fillable = ['name', 'company_id', 'email', 'phone', 'password', 'photo_profile', 'role', 'role_label', 'unitkerja', 'unitkerja_label', 'otp', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getUserMenu(){
        return $this->hasMany('App\Models\User_menu')->orderBy('mp_sequence', 'ASC')->orderBy('m_sequence', 'ASC');
    }
    
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
