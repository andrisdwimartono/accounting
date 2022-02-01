<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ikuunitkerja extends Model
{
    use HasFactory;
    protected $table = 'ikuunitkerjas';
    protected $fillable = ['iku_tahun', 'iku_tahun_label', 'iku_unit_pelaksana', 'iku_unit_pelaksana_label', 'upload_dokumen', 'is_ikt', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getUnitkerja(){
        return $this->hasOne('App\Models\Unitkerja')->orderBy('no_seq', 'ASC');
    }


    function getIku(){
        return $this->hasMany('App\Models\Iku')->orderBy('no_seq', 'ASC');
    }
}
