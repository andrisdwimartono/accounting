<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plafon_kegiatan extends Model
{
    use HasFactory;
    protected $table = 'plafon_kegiatans';
    protected $fillable = ['tahun', 'tahun_label', 'programkerja', 'programkerja_label', 'unit_pelaksana',  'unit_pelaksana_label', 'kegiatan_name', 'deskripsi', 'coa', 'coa_label', 'plafon', 'updated_at', 'user_creator_id', 'user_updater_id'];
    

    function getUnitkerja(){
        return $this->hasOne('App\Models\Unitkerja')->orderBy('no_seq', 'ASC');
    }


    function getProgramkerja(){
        return $this->hasOne('App\Models\Programkerja')->orderBy('no_seq', 'ASC');
    }

    function getCoa(){
        return $this->hasOne('App\Models\Coa')->orderBy('no_seq', 'ASC');
    }
}
