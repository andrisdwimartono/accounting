<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_menu extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "menu_id",
        "is_granted",
        "mp_sequence",
        "m_sequence",
        "menu_name",
        "url",
        "menu_icon",
        "parent_id",
        "is_group_menu",
        "is_shown_at_side_menu",
        'is_view', 
        'mainmenu'
    ];

    function getMenu(){
        return $this->hasOne('App\Models\Menu');
    }
}
