<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_role_menu extends Model
{
    use HasFactory;
    protected $fillable = [
        "role",
        "menu_id",
        "is_granted"
    ];
    
    // function getMenu(){
    //     return $this->belongsToMany('App\Models\Menu'::class);
    // }

    function getMenu(){
        return $this->hasOne('App\Models\Menu');
    }
}
