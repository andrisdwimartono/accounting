<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilaipagu extends Model
{
    use HasFactory;
    protected $table = 'nilaipagus';
    protected $fillable = ['parent_id', 'no_seq', 'unitkerja', 'unitkerja_label', 'maxbiaya', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getSettingpagupendapatan(){
        return $this->hasOne('App\Models\Settingpagupendapatan');
    }
}
