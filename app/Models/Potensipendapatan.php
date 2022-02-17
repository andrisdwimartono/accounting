<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Potensipendapatan extends Model
{
    use HasFactory;
    protected $table = 'potensipendapatans';
    protected $fillable = ['parent_id', 'no_seq', 'unitkerja2', 'unitkerja2_label', 'coa', 'coa_label', 'nominalpendapatan', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getSettingpagupendapatan(){
        return $this->hasOne('App\Models\Settingpagupendapatan');
    }
}
