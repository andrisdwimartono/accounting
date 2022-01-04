<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aruskas extends Model
{
    use HasFactory;
    protected $table = 'aruskass';
    protected $fillable = ['tahun_periode', 'bulan_periode', 'coa', 'coa_label', 'jenisbayar', 'jenisbayar_label', 'jenis_aktivitas', 'fheader', 'debet', 'credit', 'unitkerja', 'unitkerja_label', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getCoa(){
        return $this->hasOne('App\Models\Coa')->orderBy('no_seq', 'ASC');
    }


    function getJenisbayar(){
        return $this->hasOne('App\Models\Jenisbayar')->orderBy('no_seq', 'ASC');
    }
}
