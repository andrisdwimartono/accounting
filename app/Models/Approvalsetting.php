<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvalsetting extends Model
{
    use HasFactory;
    protected $table = 'approvalsettings';
    protected $fillable = ['parent_id', 'no_seq', 'role', 'role_label', 'jenismenu', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getGlobalsetting(){
        return $this->hasOne('App\Models\Globalsetting');
    }
}
