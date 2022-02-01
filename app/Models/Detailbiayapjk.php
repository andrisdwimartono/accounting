<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailbiayapjk extends Model
{
    use HasFactory;
    protected $table = 'detailbiayapjks';
    protected $fillable = ['parent_id', 'no_seq', 'coa', 'coa_label', 'deskripsibiaya', 'nominalbiaya', 'kegiatan_id', 'detailbiayakegiatan_id', 'status_detail', 'desc_detail', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getPjk(){
        return $this->hasOne('App\Models\Pjk');
    }

    function getKegiatan(){
        return $this->hasOne('App\Models\Kegiatan');
    }
}
