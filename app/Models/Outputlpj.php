<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outputlpj extends Model
{
    use HasFactory;
    protected $table = 'outputlpjs';
    protected $fillable = ['parent_id', 'no_seq', 'iku', 'iku_label', 'Indikator', 'keterangan', 'target', 'satuan_target', 'realisasi', 'satuan_realisasi', 'file_bukti', 'link_bukti', 'hasil_pencapaian', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getPjk(){
        return $this->hasOne('App\Models\Pjk');
    }
}
