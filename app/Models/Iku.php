<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku extends Model
{
    use HasFactory;
    protected $table = 'ikus';
    protected $fillable = ['parent_id', 'no_seq', 'jenis_iku', 'jenis_iku_label', 'iku_name', 'unit_pelaksana', 'unit_pelaksana_label', 'tahun', 'unit_pendukung', 'unit_pendukung_label', 'nilai_standar_opt', 'nilai_standar_opt_label', 'nilai_standar', 'satuan_nilai_standar', 'satuan_nilai_standar_label', 'nilai_baseline_opt', 'nilai_baseline_opt_label', 'nilai_baseline', 'satuan_nilai_baseline', 'satuan_nilai_baseline_label', 'nilai_renstra_opt', 'nilai_renstra_opt_label', 'nilai_renstra', 'satuan_nilai_renstra', 'satuan_nilai_renstra_label', 'nilai_target_tahunan_opt', 'nilai_target_tahunan_opt_label', 'nilai_target_tahunan', 'satuan_nilai_target_tahunan', 'satuan_nilai_target_tahunan_label', 'keterangan', 'sumber_data', 'rujukan', 'is_ikt', 'user_creator_id', 'upload_detail', 'user_updater_id', 'updated_at'];

    function getIkuunitkerja(){
        return $this->hasOne('App\Models\Ikuunitkerja');
    }

}
