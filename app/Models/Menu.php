<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['mp_sequence', 'm_sequence', 'menu_name', 'url', 'menu_icon', 'is_shown_at_side_menu', 'is_group_menu', 'parent_id', 'is_view', 'mainmenu', 'user_creator_id', 'user_updater_id'];
}
