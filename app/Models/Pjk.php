<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pjk extends Model
{
    use HasFactory;
    protected $table = 'pjks';
    protected $fillable = ['kegiatan_id', 'unit_pelaksana', 'unit_pelaksana_label', 'tahun', 'tahun_label', 'iku', 'iku_label', 'kegiatan_name', 'Deskripsi', 'output', 'proposal', 'status', 'desc_pjk', 'laporan_pjk', 'user_pjk', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getUnitkerja(){
        return $this->hasOne('App\Models\Unitkerja')->orderBy('no_seq', 'ASC');
    }


    function getIku(){
        return $this->hasOne('App\Models\Iku')->orderBy('no_seq', 'ASC');
    }


    function getDetailbiayakegiatan(){
        return $this->hasMany('App\Models\Detailbiayakegiatan')->orderBy('no_seq', 'ASC');
    }
}
