<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settingpagupendapatan extends Model
{
    use HasFactory;
    protected $table = 'settingpagupendapatans';
    protected $fillable = ['tahun', 'tahun_label', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getNilaipagu(){
        return $this->hasMany('App\Models\Nilaipagu')->orderBy('no_seq', 'ASC');
    }


    function getPotensipendapatan(){
        return $this->hasMany('App\Models\Potensipendapatan')->orderBy('no_seq', 'ASC');
    }
}
